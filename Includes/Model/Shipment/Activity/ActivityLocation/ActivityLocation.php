<?php

declare(strict_types=1);

namespace UpsTracking\Includes\Model\Shipment\Activity\ActivityLocation;

final class ActivityLocation
{
    private ?Address $address;
    private ?string $code;
    private ?string $description;
    private ?string $signedForByName;

    private function __construct(Address $address, string $code, string $description, string $signedForByName)
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

    private static function fromArray(array $activityLocation): ActivityLocation {
        $address = $activityLocation['Address'];
        $code = $activityLocation['Code'];
        $description = $activityLocation['Description'];
        $signedForByName = $activityLocation['SignedForByName'];

        return new ActivityLocation($address, $code, $description, $signedForByName);
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