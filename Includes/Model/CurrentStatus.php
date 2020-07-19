<?php

declare(strict_types=1);

namespace UpsTracking\Includes\Model;

final class CurrentStatus
{
    private string $code;
    private string $description;

    private function __construct(string $code, string $description)
    {
        $this->code = $code;
        $this->description = $description;
    }

    public static function fromArray(?array $currentStatus): ?CurrentStatus {
        if (!is_array($currentStatus)) {
            return null;
        }

        $code = $currentStatus['Code'];
        $description = $currentStatus['Description'];

        return new CurrentStatus($code, $description);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

}