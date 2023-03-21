<?php declare(strict_types = 1);

namespace App\Type;

interface TypeInterface
{
    /**
     * @param string|null $type
     *
     * @return bool
     */
    public function isSupported(?string $type): bool;

    /**
     * @param mixed $propertyValue
     * @param mixed $mapping
     *
     * @return mixed
     */
    public function normalize(mixed $propertyValue, mixed $mapping);

    /**
     * @param mixed $propertyValue
     * @param mixed $mapping
     *
     * @return mixed
     */
    public function denormalize(mixed $propertyValue, mixed $mapping);
}
