<?php declare(strict_types = 1);

namespace App\Service;

use App\Attribute\Exception\EmarsysAttributeException;
use App\Attribute\Reader\PropertyReader;
use App\Dto\ContactDto;
use App\Type\SingleChoicesType;
use App\Type\TypeInterface;
use Exception;

class CrmMappingService
{
    /**
     * @var TypeInterface[]
     */
    private array $supportedTypes = [];

    public function __construct()
    {
        $this->supportedTypes = [
            new SingleChoicesType()
        ];
    }

    /**
     * @param object $object
     *
     * @return array
     * @throws EmarsysAttributeException
     * @throws Exception
     */
    public function normalize(
        object $object
    ): array {
        $fields = [];

        $annotations = new PropertyReader();
        $properties = $annotations->getAnnotationsFromProperties(
            $object
        );

        foreach ($properties->getProperties() as $property) {

            // skip properties value is null
            if (null === $property->getPropertyValue()) {
                continue;
            }

            $value = $property->getPropertyValue();

            $attribute = $property?->getEmarsysFieldAttribute();
            if ($attribute) {
                foreach ($this->supportedTypes as $supportedType) {
                    if ($supportedType->isSupported($attribute->getType())) {
                        $value = $supportedType->normalize(
                            $value,
                            $attribute->getMapping()
                        );
                    }
                }
            }

            $fields[$attribute->getId()] = $value;
        }

        return $fields;
    }

    /**
     * @param array $fields
     * @param object $object
     *
     * @return ContactDto
     * @throws EmarsysAttributeException
     */
    public function denormalize(
        array $fields,
        object $object
    ): object {

        $annotations = new PropertyReader();
        $properties = $annotations->getAnnotationsFromProperties(
            $object
        );

        foreach ($fields as $fieldId => $fieldValue) {
            if (null !== $fieldValue && $property = $properties->findPropertyByFieldId($fieldId)) {

                $attribute = $property?->getEmarsysFieldAttribute();
                if ($attribute) {
                    foreach ($this->supportedTypes as $supportedType) {
                        if ($supportedType->isSupported($attribute->getType())) {
                            $fieldValue = $supportedType->denormalize(
                                $fieldValue,
                                $attribute->getMapping()
                            );
                        }
                    }
                }

                $property->getReflectionProperty()->setValue(
                    $object,
                    $fieldValue
                );
            }
        }
        return $object;
    }
}
