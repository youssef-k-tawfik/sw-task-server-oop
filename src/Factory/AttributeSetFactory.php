<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AttributeSet\Interface\AttributeSetInterface;
use App\Entity\AttributeSet\TextAttributeSet;
use App\Entity\AttributeSet\SwatchAttributeSet;

/**
 * Factory for creating attribute sets.
 */
class AttributeSetFactory
{
    /**
     * @var array<string, string> Mapping of attribute set types to their corresponding classes.
     */
    private static array $attributeSetMap = [
        'text'   => TextAttributeSet::class,
        'swatch' => SwatchAttributeSet::class,
    ];

    /**
     * Create an attribute set.
     *
     * @param string $id    Identifier (for example "Size" or "Color").
     * @param string $name  Display name of the attribute set.
     * @param string $type  Either "text" or "swatch".
     * @param array  $items Array of attribute items.
     * @return AttributeSetInterface The created attribute set.
     * @throws \InvalidArgumentException If the attribute set type is unknown.
     */
    public static function create(
        string $id,
        string $name,
        string $type,
        array  $items = []
    ): AttributeSetInterface {
        $type = strtolower($type);
        if (!isset(self::$attributeSetMap[$type])) {
            throw new \InvalidArgumentException("Unknown attribute set type: {$type}");
        }
        $attributeSetClass = self::$attributeSetMap[$type];
        return new $attributeSetClass($id, $name, $items);
    }
}
