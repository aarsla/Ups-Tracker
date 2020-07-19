<?php

declare(strict_types=1);

namespace UpsTracking\Includes\Model\Shipment;

final class InquiryNumber
{
    private string $code;
    private string $value;

    private function __construct(string $code, string $value)
    {
        $this->code = $value;
        $this->value = $value;
    }

    public static function fromArray(array $inquiryNumber): InquiryNumber {
        $code = $inquiryNumber['Code'];
        $value = $inquiryNumber['Value'];

        return new InquiryNumber($code, $value);
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
    public function getValue(): string
    {
        return $this->value;
    }

}