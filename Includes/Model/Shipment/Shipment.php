<?php

declare(strict_types=1);

namespace UpsTracking\Includes\Model\Shipment;

final class Shipment
{
    private InquiryNumber $inquiryNumber;
    private ?ShipmentType $shipmentType;
    private ?CurrentStatus $currentStatus;
    private ?ShipmentWeight $shipmentWeight;
    private ?string $pickupDate;
    private ?Service $service;
    private ?Package $package;

    private function __construct(
        InquiryNumber $inquiryNumber,
        ?ShipmentType $shipmentType,
        ?CurrentStatus $currentStatus,
        ?ShipmentWeight $shipmentWeight,
        ?string $pickupDate,
        ?Service $service,
        ?Package $package
    )
    {
        $this->inquiryNumber = $inquiryNumber;
        $this->shipmentType = $shipmentType;
        $this->currentStatus = $currentStatus;
        $this->shipmentWeight = $shipmentWeight;
        $this->pickupDate = $pickupDate;
        $this->service = $service;
        $this->package = $package;
    }

    public static function fromResponse(array $shipping): Shipment {
        $inquiryNumber = InquiryNumber::fromArray($shipping['InquiryNumber']);
        $shipmentType = ShipmentType::fromNullableArray(Shipment::arrayOrNull($shipping, 'ShipmentType'));
        $currentStatus = CurrentStatus::fromNullableArray(Shipment::arrayOrNull($shipping, 'CurrentStatus'));
        $shipmentWeight = ShipmentWeight::fromNullableArray(Shipment::arrayOrNull($shipping, 'ShipmentWeight'));
        $pickupDate = Shipment::valueOrNull($shipping, 'PickupDate');
        $service = Service::fromNullableArray(Shipment::arrayOrNull($shipping, 'Service'));
        $package = Package::fromNullableArray(Shipment::arrayOrNull($shipping, 'Package'));

        return new Shipment(
            $inquiryNumber,
            $shipmentType,
            $currentStatus,
            $shipmentWeight,
            $pickupDate,
            $service,
            $package
        );
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

    private static function valueOrNull(array $array, string $index): ?string
    {
        if (!is_array($array)) {
            return null;
        }

        if (!array_key_exists($index, $array)) {
            return null;
        }

        return $array ? (string)$array[$index] : null;
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

    /**
     * @return ShipmentWeight|null
     */
    public function getShipmentWeight(): ?ShipmentWeight
    {
        return $this->shipmentWeight;
    }

    /**
     * @return string|null
     */
    public function getPickupDate(): ?string
    {
        return $this->pickupDate;
    }

    /**
     * @return Service|null
     */
    public function getService(): ?Service
    {
        return $this->service;
    }

    /**
     * @return Package|null
     */
    public function getPackage(): ?Package
    {
        return $this->package;
    }

}