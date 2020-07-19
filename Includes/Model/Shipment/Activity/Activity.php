<?php

declare(strict_types=1);

namespace UpsTracking\Includes\Model\Shipment\Activity;

final class Activity
{
    private ?ActivityLocation $location;
    private ?ActivityStatus $status;
    private ?string $description;
    private ?string $date;
    private ?string $time;

    private function __construct(?ActivityLocation $location, ?ActivityStatus $status, ?string $description, ?string $date, ?string $time)
    {
        $this->location = $location;
        $this->status = $status;
        $this->description = $description;
        $this->date = $date;
        $this->time = $time;
    }

    public static function fromNullableArray(?array $activities): ?array
    {
        if (!is_array($activities)) {
            return null;
        }

        $array = [];

        if (isset($activities[0])) {
            foreach ($activities as $activity) {
                $array[] = Activity::fromArray($activity);
            }
        } else {
            $array[] = Activity::fromArray($activities);
        }

        return empty($array) ? null : $array;
    }

    private static function fromArray(array $activity): ?Activity {
        $location = ActivityLocation::fromNullableArray(Activity::arrayOrNull($activity, 'ActivityLocation'));
        $status = ActivityStatus::fromNullableArray(Activity::arrayOrNull($activity, 'Status'));
        $description = isset($activity['Description']) ? $activity['Description'] : null;
        $date = isset($activity['Date']) ? $activity['Date'] : null;
        $time = isset($activity['Time']) ? $activity['Time'] : null;

        if (!$location && !$status && !$description && !$date && !$time) {
            return null;
        }

        return new Activity($location, $status, $description, $date, $time);
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
     * @return ActivityLocation|null
     */
    public function getLocation(): ?ActivityLocation
    {
        return $this->location;
    }

    /**
     * @return ActivityStatus|null
     */
    public function getStatus(): ?ActivityStatus
    {
        return $this->status;
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
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

}