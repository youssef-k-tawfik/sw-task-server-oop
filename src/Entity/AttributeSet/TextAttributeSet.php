<?php

declare(strict_types=1);

namespace App\Entity\AttributeSet;

use App\Entity\AttributeSet\Base\BaseAttributeSet;

/**
 * Represents a text attribute set.
 */
final class TextAttributeSet extends BaseAttributeSet
{
    /**
     * @var string The type of the attribute set.
     */
    private const TYPE = 'text';

    /**
     * @param string $id    The unique identifier of the text attribute set.
     * @param string $name  The name of the text attribute set.
     * @param array  $items The list of attributes in the text attribute set.
     */
    public function __construct(
        string $id,
        string $name,
        array $items = []
    ) {
        parent::__construct($id, $name, self::TYPE, $items);
    }
}
