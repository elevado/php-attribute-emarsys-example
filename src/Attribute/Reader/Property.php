<?php declare(strict_types = 1);

namespace App\Attribute\Reader;

use App\Attribute\EmarsysField;
use ReflectionProperty;

class Property
{
    /**
     * @var ReflectionProperty
     */
    private ReflectionProperty $reflectionProperty;

    /**
     * @var mixed
     */
    private mixed $propertyValue;

    /**
     * @var EmarsysField|null
     */
    private ?EmarsysField $emarsysFieldAttribute;

    /**
     * @param object $object
     * @param ReflectionProperty $reflectionProperty
     */
    public function __construct(object $object, ReflectionProperty $reflectionProperty)
    {
        $this->reflectionProperty = $reflectionProperty;
        $this->reflectionProperty->setAccessible(true);
        $this->propertyValue = $this->reflectionProperty->getValue($object);

        $propertyAttributes = $this->reflectionProperty->getAttributes();

        foreach ($propertyAttributes as $propertyAttribute) {
            $attribute = $propertyAttribute->newInstance();
            if ($attribute instanceof EmarsysField) {
                $this->emarsysFieldAttribute = $attribute;
            }
        }
    }

    /**
     * @return string
     */
    public function getFieldId(): string
    {
        return (string)$this->getEmarsysFieldAttribute()->getId(); // Force string
    }

    /**
     * @return string
     */
    public function getPropertyName(): string
    {
        return $this->reflectionProperty->name;
    }

    /**
     * @return ReflectionProperty|null
     */
    public function getReflectionProperty(): ?ReflectionProperty
    {
        return $this->reflectionProperty;
    }

    /**
     * @return mixed
     */
    public function getPropertyValue(): mixed
    {
        return $this->propertyValue;
    }

    /**
     * @return EmarsysField|null
     */
    public function getEmarsysFieldAttribute(): ?EmarsysField
    {
        return $this->emarsysFieldAttribute;
    }
}
