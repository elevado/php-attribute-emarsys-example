# Custom attribute example for PHP8.x.

Example of a custom attribute for the article [Create a custom Symfony Normalizer for mapping values](https://dev.to/elevado/create-a-custom-symfony-normalizer-for-mapping-values-4nc2).

## Docker image

### Start docker image
```bash
docker compose -f docker-compose.yml up --build -d
```

### Run composer install
```bash
docker exec attribute_article composer install
```

### Run tests
```bash
docker exec attribute_article vendor/bin/phpunit
```

## Example

### Create a contact
```php
use Snowcap\Emarsys\Client;
use Snowcap\Emarsys\CurlClient;

$httpClient = new CurlClient();
$client = new Client($httpClient, EMARSYS_API_USERNAME, EMARSYS_API_SECRET);

class ContactDto
{
    #[Emarsys(id: '1')]
    private ?string $firstname = null;

    #[Emarsys(id: '2')]
    private ?string $lastname = null;

    #[Emarsys(id: '3')]
    private ?string $email = null;

    #[Emarsys(id: '46', type: Emarsys::TYPE_SINGLE_CHOICES, mapping: ['1' => 'MALE', '2' => 'FEMALE', '6' => 'DIVERS'])]
    private ?string $salutation = null;

    #[Emarsys(id: '100674', type: Emarsys::TYPE_SINGLE_CHOICES, mapping: ['1' => true, '2' => false])]
    private ?bool $marketingInformation = null;

    /* getter and setter */
}

$contactDto->setSalutation('FEMALE');
$contactDto->setFirstname('Jane');
$contactDto->setEmail('jane.doe@example.com');
$contactDto->setMarketingInformation(true);

// Request handling: Create request
$crmMappingService = new CrmMappingService();
$fields = $crmMappingService->normalize($contactDto);
/*
    [
        "1" => "Jane",
        "2" => "Doe",
        "3" => "jane.doe@example.com",
        "46" => "2",
        "100674" => "1"
    ]
*/
$client->createContact($fields);
```

### Find a contact
```php
use Snowcap\Emarsys\Client;
use Snowcap\Emarsys\CurlClient;

$httpClient = new CurlClient();
$client = new Client($httpClient, EMARSYS_API_USERNAME, EMARSYS_API_SECRET);

$response = $client->getContactData([3 => 'example@example.com']);
$fields = $response->getData();
/*
    [
        "1" => "Jane",
        "2" => "Doe",
        "3" => "jane.doe@example.com",
        "46" => "2",
        "100674" => "1"
    ]
*/

$crmMappingService = new CrmMappingService();
$contactDto = $crmMappingService->denormalize($fields, new ContactDto());
/*
    App\Dto\ContactDto Object
    (
        [firstname:App\Dto\ContactDto:private] => Jane
        [lastname:App\Dto\ContactDto:private] => Doe
        [email:App\Dto\ContactDto:private] => jane.doe@example.com
        [salutation:App\Dto\ContactDto:private] => FEMALE
        [marketingInformation:App\Dto\ContactDto:private] => 1
    )
*/
```
