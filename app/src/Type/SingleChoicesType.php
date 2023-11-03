<?php declare(strict_types = 1);

namespace App\Type;

use App\Attribute\Exception\EmarsysAttributeException;

class SingleChoicesType implements TypeInterface
{
    public const TYPE = 'single-choices';

    /**
     * @param string|null $type
     *
     * @return bool
     */
    public function isSupported(?string $type): bool
    {
        return self::TYPE === $type;
    }

    /**
     * @param mixed $propertyValue
     * @param mixed $mapping
     *
     * @return string|null
     * @throws EmarsysAttributeException
     */
    public function normalize(mixed $propertyValue, mixed $mapping): ?string
    {
        if (!is_array($mapping)) {
            throw new EmarsysAttributeException('$mapping must be of type array.');
        }

        $fieldValueId = array_search((string)$propertyValue, $mapping);
        if($fieldValueId) {
            return (string)$fieldValueId;
        }

        return null;
    }

    /**
     * @param mixed $propertyValue
     * @param mixed $mapping
     *
     * @return string|null
     * @throws EmarsysAttributeException
     */
    public function denormalize(mixed $propertyValue, mixed $mapping): mixed
    {
        if (!is_array($mapping)) {
            throw new EmarsysAttributeException('$mapping must be of type array.');
        }

        foreach ($mapping as $fieldValueId => $value) {
            if ((string)$fieldValueId === $propertyValue) {
                return $value;
            }
        }

        return null;
    }
}
