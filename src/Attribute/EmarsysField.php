<?php declare(strict_types = 1);

namespace App\Attribute;

use App\Type\SingleChoicesType;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class EmarsysField
{
    public const TYPE_SINGLE_CHOICES = SingleChoicesType::TYPE;

    /**
     * @var string|int|null
     */
    private string|null|int $id;

    /**
     * @var string|null
     */
    private string|null $type;

    /**
     * @var array|null
     */
    private array|null $mapping;

    /**
     * @param int|string|null $id
     * @param string|null $type
     * @param array|null $mapping
     */
    public function __construct(int|string|null $id, ?string $type = null, ?array $mapping = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->mapping = $mapping;
    }

    /**
     * @return string|null
     */
    public function getId(): string|null
    {
        return (string)$this->id;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return array|null
     */
    public function getMapping(): ?array
    {
        return $this->mapping;
    }
}
