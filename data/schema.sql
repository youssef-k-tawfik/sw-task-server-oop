-- Categories Table
CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

-- Brands Table
CREATE TABLE brand (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

-- Products Table
CREATE TABLE product (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    in_stock BOOLEAN NOT NULL DEFAULT TRUE,
    description TEXT,
    category_id INT,
    brand_id INT,
    FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE SET NULL,
    FOREIGN KEY (brand_id) REFERENCES brand(id) ON DELETE SET NULL
);

-- Galleries Table (Images associated with products)
CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NOT NULL,
    product_id VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

-- Currencies Table
CREATE TABLE currency (
    id INT AUTO_INCREMENT PRIMARY KEY,
    symbol VARCHAR(10) NOT NULL UNIQUE,
    label VARCHAR(255) NOT NULL UNIQUE
);

-- Prices Table
CREATE TABLE price (
    id INT AUTO_INCREMENT PRIMARY KEY,
    amount DECIMAL(10, 2) NOT NULL CHECK (amount >= 0),
    currency_id INT NOT NULL,
    product_id VARCHAR(255) NOT NULL,
    FOREIGN KEY (currency_id) REFERENCES currency(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

-- Attribute Sets Table
CREATE TABLE attribute_set (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    type VARCHAR(50) NOT NULL
);

-- Attributes Table
CREATE TABLE attribute (
    id VARCHAR(255),
    value VARCHAR(255) NOT NULL,
    display_value VARCHAR(255) NOT NULL,
    attribute_set_id VARCHAR(255) NOT NULL,
    PRIMARY KEY (id, attribute_set_id),
    FOREIGN KEY (attribute_set_id) REFERENCES attribute_set(id) ON DELETE CASCADE
);

-- Product Attributes Table (Many-to-Many Relation)
CREATE TABLE product_attributes (
    product_id VARCHAR(255) NOT NULL,
    attribute_id VARCHAR(255) NOT NULL,
    attribute_set_id VARCHAR(255) NOT NULL,
    PRIMARY KEY (product_id, attribute_id, attribute_set_id),
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE,
    FOREIGN KEY (attribute_id, attribute_set_id) REFERENCES attribute(id, attribute_set_id) ON DELETE CASCADE
);

-- Orders Table (Using 'orders' to avoid reserved keywords)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(255) NOT NULL UNIQUE,
    total_amount DECIMAL(10, 2) NOT NULL CHECK (total_amount >= 0),
    currency_id INT,
    placed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (currency_id) REFERENCES currency(id) ON DELETE SET NULL
);

-- Order Products Table (Order-Product Relationship)
CREATE TABLE order_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id VARCHAR(255) NOT NULL,
    quantity INT NOT NULL CHECK (quantity > 0),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

-- Order Product Attributes Table (Many-to-Many Relation)
CREATE TABLE order_product_attributes (
    order_product_id INT NOT NULL,
    attribute_id VARCHAR(255) NOT NULL,
    attribute_set_id VARCHAR(255) NOT NULL,
    PRIMARY KEY (order_product_id, attribute_id, attribute_set_id),
    FOREIGN KEY (order_product_id) REFERENCES order_products(id) ON DELETE CASCADE,
    FOREIGN KEY (attribute_id, attribute_set_id) REFERENCES attribute(id, attribute_set_id) ON DELETE CASCADE
);
