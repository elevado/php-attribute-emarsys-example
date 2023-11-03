<?php declare(strict_types = 1);

namespace App\Attribute\Reader;

use App\Attribute\Exception\EmarsysAttributeException;

class Properties
{
    /**
     * @var Property[]
     */
    private array $properties;

    /**
     * @param Property $property
     *
     * @return void
     * @throws EmarsysAttributeException
     */
    public function addProperty(Property $property): void
    {
        if (isset($this->properties[$property->getFieldId()])) {
            throw new EmarsysAttributeException(sprintf(
                'The FieldID "%s" has already been defined for the property "%s".',
                $property->getFieldId(),
                $this->properties[$property->getFieldId()]->getPropertyName()
            ));
        }
        $this->properties[$property->getFieldId()] = $property;
    }

    /**
     * @param int|string $fieldId
     *
     * @return Property|null
     */
    public function findPropertyByFieldId(int|string $fieldId): ?Property
    {
        if (isset($this->properties[(string)$fieldId])) {
            return $this->properties[(string)$fieldId];
        }
        return null;
    }

    /**
     * @return Property[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }
}
