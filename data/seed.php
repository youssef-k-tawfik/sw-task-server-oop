<?php

declare(strict_types=1);

use App\Utils\CustomLogger;
use App\Config\Database;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';

// Load environment variables
CustomLogger::logInfo("Loading environment variables...");
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
CustomLogger::logInfo("Environment variables loaded successfully.");

// Check if file exists
CustomLogger::logInfo("Checking if data file exists...");
$dataFile = __DIR__ . '/data.json';
if (!file_exists($dataFile)) {
    die("Data file not found: $dataFile");
}
CustomLogger::logInfo("Data file found!");

// Read data from file
CustomLogger::logInfo("Reading data from file...");
$json = file_get_contents($dataFile);
$data = json_decode($json, true);
if ($data === null) {
    die("Invalid JSON data.");
}
CustomLogger::logInfo("Data read successfully.");

CustomLogger::logInfo("Connecting to the database...");
$db = new Database();
$db->connect();
$pdo = $db->getConnection();
CustomLogger::logInfo("Database connected successfully.");

CustomLogger::logInfo("Starting database seeding process...");
try {
    // Start transaction
    $pdo->beginTransaction();

    // 1. Seed Categories
    CustomLogger::logInfo("Seeding categories...");
    $insertCategoryStmt = $pdo->prepare(
        "INSERT INTO category (name) VALUES (:name)
         ON DUPLICATE KEY UPDATE name = name"
    );
    foreach ($data['data']['categories'] as $category) {
        $insertCategoryStmt->execute([':name' => $category['name']]);
    }
    CustomLogger::logInfo("Categories seeded successfully!");

    // Build category map: name => id
    $categoryMap = [];
    $stmt = $pdo->query("SELECT id, name FROM category");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $categoryMap[$row['name']] = $row['id'];
    }

    // 2. Seed Brands
    CustomLogger::logInfo("Seeding brands...");
    // Collect brand names from products.
    $brands = [];
    foreach ($data['data']['products'] as $product) {
        $brands[$product['brand']] = true;
    }
    $insertBrandStmt = $pdo->prepare(
        "INSERT INTO brand (name) VALUES (:name)
         ON DUPLICATE KEY UPDATE name = name"
    );
    foreach (array_keys($brands) as $brandName) {
        $insertBrandStmt->execute([':name' => $brandName]);
    }
    CustomLogger::logInfo("Brands seeded successfully!");

    // Build brand map: name => id
    $brandMap = [];
    $stmt = $pdo->query("SELECT id, name FROM brand");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $brandMap[$row['name']] = $row['id'];
    }

    // 3. Seed Currency (Assuming only USD for now)
    CustomLogger::logInfo("Seeding currencies...");
    $insertCurrencyStmt = $pdo->prepare(
        "INSERT INTO currency (symbol, label) VALUES (:symbol, :label)
         ON DUPLICATE KEY UPDATE symbol = symbol"
    );
    // Insert USD if not exists.
    $insertCurrencyStmt->execute([
        ':symbol' => '$',
        ':label' => 'USD'
    ]);
    CustomLogger::logInfo("Currencies seeded successfully!");

    // Build currency map
    $currencyMap = [];
    $stmt = $pdo->query("SELECT id, label FROM currency");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $currencyMap[$row['label']] = $row['id'];
    }

    // 4. Seed Products, Galleries, Prices, Attribute Sets, Attributes, and Product_Attributes
    CustomLogger::logInfo("Preparing to seed products, galleries, prices, attributes...");
    $insertProductStmt = $pdo->prepare(
        "INSERT INTO product (id, name, in_stock, description, category_id, brand_id)
         VALUES (:id, :name, :in_stock, :description, :category_id, :brand_id)"
    );

    $insertGalleryStmt = $pdo->prepare(
        "INSERT INTO gallery (url, product_id)
         VALUES (:url, :product_id)"
    );

    $insertPriceStmt = $pdo->prepare(
        "INSERT INTO price (amount, currency_id, product_id)
         VALUES (:amount, :currency_id, :product_id)"
    );

    $insertAttributeSetStmt = $pdo->prepare(
        "INSERT INTO attribute_set (id, name, type)
         VALUES (:id, :name, :type)
         ON DUPLICATE KEY UPDATE name = name"
    );

    $insertAttributeStmt = $pdo->prepare(
        "INSERT INTO attribute (id, value, display_value, attribute_set_id)
         VALUES (:id, :value, :display_value, :attribute_set_id)
         ON DUPLICATE KEY UPDATE value = :value_update"
    );

    $insertProductAttributeStmt = $pdo->prepare(
        "INSERT INTO product_attributes (product_id, attribute_id, attribute_set_id)
         VALUES (:product_id, :attribute_id, :attribute_set_id)
         ON DUPLICATE KEY UPDATE product_id = product_id"
    );

    foreach ($data['data']['products'] as $product) {
        CustomLogger::logInfo("Seeding product: " . $product['name']);

        // Map category and brand using the maps built above.
        $categoryName = $product['category'];
        $categoryId = $categoryMap[$categoryName] ?? null;
        $brandId = $brandMap[$product['brand']] ?? null;
        // Insert product
        $insertProductStmt->execute([
            ':id' => $product['id'],
            ':name' => $product['name'],
            ':in_stock' => $product['inStock'] ? 1 : 0,
            ':description' => $product['description'],
            ':category_id' => $categoryId,
            ':brand_id' => $brandId
        ]);

        // Insert galleries
        if (!empty($product['gallery'])) {
            foreach ($product['gallery'] as $url) {
                $insertGalleryStmt->execute([
                    ':url' => $url,
                    ':product_id' => $product['id']
                ]);
            }
        }

        // Insert prices (assuming one price per product)
        if (!empty($product['prices'])) {
            foreach ($product['prices'] as $price) {
                $currencyLabel = $price['currency']['label'];
                $currencyId = $currencyMap[$currencyLabel] ?? null;
                $insertPriceStmt->execute([
                    ':amount' => $price['amount'],
                    ':currency_id' => $currencyId,
                    ':product_id' => $product['id']
                ]);
            }
        }

        // Seed attributes: iterate over attribute sets for the product.
        if (!empty($product['attributes'])) {
            foreach ($product['attributes'] as $attrSet) {
                // Insert attribute_set record.
                $attrSetId = $attrSet['id']; // e.g., "Size" or "Color"
                $insertAttributeSetStmt->execute([
                    ':id' => $attrSetId,
                    ':name' => $attrSet['name'],
                    ':type' => $attrSet['type']
                ]);

                // For each attribute item in the set.
                if (!empty($attrSet['items'])) {
                    foreach ($attrSet['items'] as $attr) {
                        // Insert attribute item.
                        $insertAttributeStmt->execute([
                            ':id' => $attr['id'],
                            ':value' => $attr['value'],
                            ':display_value' => $attr['displayValue'],
                            ':attribute_set_id' => $attrSetId,
                            ':value_update' => $attr['value']
                        ]);

                        // Create mapping in product_attributes table.
                        $insertProductAttributeStmt->execute([
                            ':product_id' => $product['id'],
                            ':attribute_id' => $attr['id'],
                            ':attribute_set_id' => $attrSetId
                        ]);
                    }
                }
            }
        }

        CustomLogger::logInfo("Product seeded successfully: " . $product['name']);
    }

    // Commit transaction
    $pdo->commit();

    CustomLogger::logInfo("Seeding process completed!");
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error seeding data: " . $e->getMessage() . "\n";
} finally {
    $db->disconnect();
    CustomLogger::logInfo("Database connection closed.");
}
