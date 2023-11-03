<?php declare(strict_types = 1);

namespace App\Tests;

use App\Attribute\EmarsysField;
use App\Attribute\Exception\EmarsysAttributeException;
use App\Dto\ContactDto;
use App\Service\CrmMappingService;
use PHPUnit\Framework\TestCase;

/**
 * @covers
 */
class CrmMappingServiceTest extends TestCase
{
    public array $contactDto = [
        "1" => "Jane",
        "2" => "Doe",
        "3" =>"jane.doe@example.com",
        "46" =>"2",
        "100674" => "1"
    ];

    public function testToEmarsysFields()
    {
        $contactDto = new ContactDto();
        $contactDto->setSalutation('FEMALE');
        $contactDto->setFirstname('Jane');
        $contactDto->setLastname('Doe');
        $contactDto->setEmail('jane.doe@example.com');
        $contactDto->setMarketingInformation(true);

        $crmMappingService = new CrmMappingService();
        $result = $crmMappingService->normalize($contactDto);

        $this->assertEquals($this->contactDto, $result);
    }

    public function testToEmarsysFieldsSkipNull()
    {
        $contactDto = new ContactDto();
        $contactDto->setSalutation('FEMALE');
        $contactDto->setFirstname('Jane');
        $contactDto->setEmail('jane.doe@example.com');
        $contactDto->setMarketingInformation(true);

        $crmMappingService = new CrmMappingService();
        $result = $crmMappingService->normalize($contactDto);

        $this->assertEquals(
            (function () {
                $array = $this->contactDto;
                unset($array['2']);
                return $array;
            })(),
            $result
        );
    }

    public function testToEmarsysAttributeException()
    {
        $this->expectException(EmarsysAttributeException::class);
        $this->expectExceptionMessage('The FieldID "3" has already been defined for the property "property1".');
        $contactDto = new class () {
            #[EmarsysField(id: '3')]
            private ?string $property1 = null;

            #[EmarsysField(id: '3')]
            private ?string $property2 = null;
        };

        $crmMappingService = new CrmMappingService();
        $crmMappingService->normalize($contactDto);
    }

    public function testResponse()
    {
        $crmMappingService = new CrmMappingService();
        $contactDto = $crmMappingService->denormalize(
            $this->contactDto,
            new ContactDto()
        );

        $this->assertSame('FEMALE', $contactDto->getSalutation());
        $this->assertSame('Jane', $contactDto->getFirstname());
        $this->assertSame('Doe', $contactDto->getLastname());
        $this->assertSame('jane.doe@example.com', $contactDto->getEmail());
        $this->assertTrue($contactDto->isMarketingInformation());
    }

}
