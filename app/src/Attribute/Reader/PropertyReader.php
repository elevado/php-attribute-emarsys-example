<?php declare(strict_types = 1);

namespace App\Attribute\Reader;

use App\Attribute\Exception\EmarsysAttributeException;
use ReflectionClass;

class PropertyReader
{
    /**
     * @param object $object
     *
     * @return Properties
     * @throws EmarsysAttributeException
     */
    public function getAnnotationsFromProperties(object $object): Properties
    {
        $reflection = new ReflectionClass($object);
        $reflectionProperties = $reflection->getProperties();
        $properties = new Properties();
        foreach ($reflectionProperties as $property) {
            $properties->addProperty(
                new Property(
                    $object,
                    $property
                )
            );
        }
        return $properties;
    }
}
