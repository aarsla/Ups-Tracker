<?php

declare(strict_types=1);

namespace UpsTracking\Includes\Model\Shipment\Activity\ActivityLocation;

final class Address
{
    private ?string $city;
    private ?string $stateProvinceCode;
    private ?string $postalCode;
    private ?string $countryCode;

    private function __construct(string $city, string $stateProvinceCode, string $postalCode, string $countryCode)
    {
        $this->city = $city;
        $this->stateProvinceCode = $stateProvinceCode;
        $this->postalCode = $postalCode;
        $this->countryCode = $countryCode;
    }

    public static function fromNullableArray(?array $address): ?Address
    {
        if (!is_array($address)) {
            return null;
        }

        return Address::fromArray($address);
    }

    private static function fromArray(array $address): Address {
        $city = $address['City'] ? $address['City'] : null;
        $stateProvinceCode = $address['StateProvinceCode'] ? $address['StateProvinceCode'] : null;
        $postalCode = $address['PostalCode'] ? $address['PostalCode'] : null;
        $countryCode = $address['CountryCode'] ? $address['CountryCode'] : null;

        return new Address($city, $stateProvinceCode, $postalCode, $countryCode);
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getStateProvinceCode(): ?string
    {
        return $this->stateProvinceCode;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

}