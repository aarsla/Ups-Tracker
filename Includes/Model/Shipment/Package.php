<?php

declare(strict_types=1);

namespace UpsTracking\Includes\Model\Shipment;

use UpsTracking\Includes\Model\Shipment\Activity\Activity;

final class Package
{
    private string $trackingNumber;
    private ?array $activities;

    private function __construct(string $trackingNumber, array $activities = [])
    {
        $this->trackingNumber = $trackingNumber;
        $this->activities = $activities;
    }

    public static function fromNullableArray(?array $package): ?Package
    {
        if (!is_array($package)) {
            return null;
        }

        return Package::fromArray($package);
    }

    private static function fromArray(array $package): Package {
        $trackingNumber = $package['TrackingNumber'];
        $activities = Activity::fromNullableArray($package['Activity']);

        return new Package($trackingNumber, $activities);
    }

    /**
     * @return string
     */
    public function getTrackingNumber(): string
    {
        return $this->trackingNumber;
    }

    /**
     * @return Activity[]|null
     */
    public function getActivities(): ?array
    {
        return $this->activities;
    }


}