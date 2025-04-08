<?php

declare(strict_types=1);

namespace App\Entity\AttributeSet;

/**
 * Represents a swatch attribute set.
 */
final class SwatchAttributeSet extends BaseAttributeSet
{
    /**
     * @var string The type of the attribute set.
     */
    private const TYPE = 'swatch';

    /**
     * @param string $id    The unique identifier of the swatch attribute set.
     * @param string $name  The name of the swatch attribute set.
     * @param array  $items The list of attributes in the swatch attribute set.
     */
    public function __construct(
        string $id,
        string $name,
        array $items = []
    ) {
        parent::__construct($id, $name, self::TYPE, $items);
    }
}
