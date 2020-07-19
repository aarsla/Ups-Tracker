<?php

declare(strict_types=1);

namespace UpsTracking\Includes\Model\Shipment\Activity;

final class ActivityLocation
{
    private ?Address $address;
    private ?string $code;
    private ?string $description;
    private ?string $signedForByName;

    public function __toString(): string
    {
        return $this->code . ' ' . $this->description;
    }

    private function __construct(?Address $address, ?string $code, ?string $description, ?string $signedForByName)
    {
        $this->address = $address;
        $this->code = $code;
        $this->description = $description;
        $this->signedForByName = $signedForByName;
    }

    public static function fromNullableArray(?array $activityLocation): ?ActivityLocation
    {
        if (!is_array($activityLocation)) {
            return null;
        }

        return ActivityLocation::fromArray($activityLocation);
    }

    private static function fromArray(array $activityLocation): ?ActivityLocation {
//        $address = isset($activityLocation['Address']) ? Address::fromNullableArray($activityLocation['Address']) : null;
        $address = Address::fromNullableArray(ActivityLocation::arrayOrNull($activityLocation, 'Address'));
        $code = isset($activityLocation['Code']) ? $activityLocation['Code'] : null;
        $description = isset($activityLocation['Description']) ? $activityLocation['Description'] : null;
        $signedForByName = isset($activityLocation['SignedForByName']) ? $activityLocation['SignedForByName'] : null;

        if (!$address && !$code && !$description && !$description && !$signedForByName) {
            return null;
        }

        return new ActivityLocation($address, $code, $description, $signedForByName);
    }

    private static function arrayOrNull(array $array, string $index): ?array {
        if (!is_array($array)) {
            return null;
        }

        if (!array_key_exists($index, $array)) {
            return null;
        }

        return $array[$index];
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getSignedForByName(): ?string
    {
        return $this->signedForByName;
    }

}