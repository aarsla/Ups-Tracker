<?php

declare(strict_types=1);

namespace UpsTracking\Includes\Model\Shipment\Activity;

use UpsTracking\Includes\Model\Shipment\Activity\ActivityLocation\ActivityStatus;

final class Activity
{
    private ?ActivityStatus $status;
    private ?string $description;
    private ?string $date;
    private ?string $time;

    private function __construct(?ActivityStatus $status, ?string $description, ?string $date, ?string $time)
    {
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
        $status = ActivityStatus::fromNullableArray($activity['Status']);
        $description = isset($activity['Description']) ? $activity['Description'] : null;
        $date = isset($activity['Date']) ? $activity['Date'] : null;
        $time = isset($activity['Time']) ? $activity['Time'] : null;

        if (!$status && $description && !$date && !$time) {
            return null;
        }

        return new Activity($status, $description, $date, $time);
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