<?php

declare(strict_types=1);

namespace UpsTracking\Includes;

// If this file is called directly, abort.
if (!defined('ABSPATH')) exit;

/**
 * Define the UPS Tracking functionality.
 *
 * @link       http://example.com
 * @since      1.0.0
 * @package    UpsTracking
 * @subpackage UpsTracking/Includes
 * @author     Your Name <email@example.com>
 */
class UPSTracker
{
    public static function getUpsTracking(string $inquiryNumber) {
        $params = UPSTracker::queryOptions($inquiryNumber);
        $jsonEncodedParams = json_encode($params);

        $response = UPSTracker::sendRequest($jsonEncodedParams);
        $decodedResponse = json_decode($response, true);

        return $decodedResponse;
    }

    private static function queryOptions(string $inquiryNumber, bool $jsonEncode = false): array {
        $upsTrackingOptions = get_option('ups-tracking-general');

        return [
            'UPSSecurity' => [
                'UsernameToken' => [
                    'Username' => $upsTrackingOptions['user-id-tx'],
                    'Password' => $upsTrackingOptions['password-tx'],
                ],
                'ServiceAccessToken' => [
                    'AccessLicenseNumber' => $upsTrackingOptions['license-key-tx'],
                ]
            ],
            'TrackRequest' => [
                'Request' => [
                    'RequestOption' => 1,
                    'TransactionReference' => [
                        'CustomerContext' => 'Test 001'
                    ]
                ],
                'InquiryNumber' => $inquiryNumber
            ]
        ];
    }

    private static function sendRequest(string $jsonEncodedParams): string {
        $upsTrackingOptions = get_option('ups-tracking-general');
        $url = $upsTrackingOptions['endpoint-url-tx'];

        $headers = [];
        $headers[] = 'Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept';
        $headers[] = 'Access-Control-Allow-Methods: POST';
        $headers[] = 'Access-Control-Allow-Origin: *';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Content-Length: ' . strlen($jsonEncodedParams);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 45);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonEncodedParams);
        $response = curl_exec($ch);

        if ((curl_errno($ch)) && (curl_errno($ch) != 0)) {
            $response = "::".curl_errno($ch)."::".curl_error($ch);
        }

        return $response;
    }
}
