<?php

declare(strict_types=1);

namespace UpsTracking\Includes\Model;

final class Shipment
{
    private InquiryNumber $inquiryNumber;
    private ?ShipmentType $shipmentType;
    private ?CurrentStatus $currentStatus;

    private function __construct(
        InquiryNumber $inquiryNumber,
        ?ShipmentType $shipmentType,
        ?CurrentStatus $currentStatus
    )
    {
        $this->inquiryNumber = $inquiryNumber;
        $this->shipmentType = $shipmentType;
        $this->currentStatus = $currentStatus;

    }

    public static function fromResponse(array $shipping): Shipment {
        $inquiryNumber = InquiryNumber::fromArray($shipping['InquiryNumber']);
        $shipmentType = ShipmentType::fromArray(Shipment::valueOrNull($shipping, 'ShipmentType'));
        $currentStatus = CurrentStatus::fromArray(Shipment::valueOrNull($shipping, 'CurrentStatus'));

        return new Shipment($inquiryNumber, $shipmentType, $currentStatus);
    }

    private static function valueOrNull(array $array, string $index) {
        if (!is_array($array)) {
            return null;
        }

        if (!array_key_exists($index, $array)) {
            return null;
        }

        return $array[$index];
    }

    /**
     * @return InquiryNumber
     */
    public function getInquiryNumber(): InquiryNumber
    {
        return $this->inquiryNumber;
    }

    /**
     * @return ShipmentType|null
     */
    public function getShipmentType(): ?ShipmentType
    {
        return $this->shipmentType;
    }

    /**
     * @return CurrentStatus|null
     */
    public function getCurrentStatus(): ?CurrentStatus
    {
        return $this->currentStatus;
    }

}