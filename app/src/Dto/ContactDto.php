<?php declare(strict_types = 1);

namespace App\Dto;

use App\Attribute\EmarsysField;

class ContactDto
{
    #[EmarsysField(id: '1')]
    private ?string $firstname = null;

    #[EmarsysField(id: '2')]
    private ?string $lastname = null;

    #[EmarsysField(id: '3')]
    private ?string $email = null;

    #[EmarsysField(id: '46', type: EmarsysField::TYPE_SINGLE_CHOICES, mapping: ['1' => 'MALE', '2' => 'FEMALE', '6' => 'DIVERS'])]
    private ?string $salutation = null;

    #[EmarsysField(id: '100674', type: EmarsysField::TYPE_SINGLE_CHOICES, mapping: ['1' => true, '2' => false])]
    private ?bool $marketingInformation = null;

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getSalutation(): ?string
    {
        return $this->salutation;
    }

    /**
     * @param string|null $salutation
     */
    public function setSalutation(?string $salutation): void
    {
        $this->salutation = $salutation;
    }

    /**
     * @return bool|null
     */
    public function isMarketingInformation(): ?bool
    {
        return $this->marketingInformation;
    }

    /**
     * @param bool|null $marketingInformation
     */
    public function setMarketingInformation(?bool $marketingInformation): void
    {
        $this->marketingInformation = $marketingInformation;
    }
}
