<?php

declare(strict_types=1);

namespace UpsTracking\Frontend;

// If this file is called directly, abort.
use UpsTracking\Includes\UPSTracker;

if (!defined('ABSPATH')) exit;

/**
 * Contact form and Shortcode template.
 *
 * @link       http://example.com
 * @since      1.0.0
 * @package    UpsTracking
 * @subpackage UpsTracking/Includes
 * @author     Your Name <email@example.com>
 */
class ContactForm
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     */
    private string $pluginSlug;

    /**
     * Initialize the class and set its properties.
     *
     * @since   1.0.0
     * @param   $pluginSlug     The name of the plugin.
     * @param   $version        The version of this plugin.
     */
    public function __construct(string $pluginSlug)
    {
        $this->pluginSlug = $pluginSlug;
    }

    /**
     * Register all the hooks of this class.
     *
     * @since   1.0.0
     * @param   $isAdmin    Whether the current request is for an administrative interface page.
     */
    public function initializeHooks(bool $isAdmin): void
    {
        // 'wp_ajax_' hook needs to be run on frontend and admin area too.
        add_action('wp_ajax_capitalizeText', array($this, 'capitalizeText'), 10);

        // Frontend
        if (!$isAdmin)
        {
            add_shortcode('ups-tracking-form', array($this, 'formShortcode'));
        }
    }

    /**
     * Contact form shortcode.
     *
     * @link https://developer.wordpress.org/reference/functions/add_shortcode/
     * Shortcode attribute names are always converted to lowercase before they are passed into the handler function. Values are untouched.
     *
     * The function called by the shortcode should never produce output of any kind.
     * Shortcode functions should return the text that is to be used to replace the shortcode.
     * Producing the output directly will lead to unexpected results.
     *
     * @since   1.0.0
     * @param   $attributes Attributes.
     * @param   $content    The post content.
     * @param   $tag        The name of the shortcode.
     * @return  The text that is to be used to replace the shortcode.
     */
    public function formShortcode($attributes = null, $content = null, string $tag = ''): string
    {
        // Enqueue scripts
        wp_enqueue_script($this->pluginSlug . 'form');

        // Inline scripts. This is how we pass data to scripts
        $script  = 'ajaxUrl = ' . json_encode(admin_url('admin-ajax.php')) . '; ';
        $script .= 'nonce = ' . json_encode(wp_create_nonce('capitalizeText')) . '; ';
        if (wp_add_inline_script($this->pluginSlug . 'form', $script, 'before') === false)
        {
            // It throws error on the Post edit screen and I don't know why. It works on the frontend.
            //exit('wp_add_inline_script() failed. Inlined script: ' . $script);
        }

        // Show the Form
        $html = $this->getFormHtml();
        $this->processFormData();

        return $html;
    }

    /**
     * This is a template how to receive data from a script, then return data back.
     * In this case it returns a text in capitalized.
     *
     * @since   1.0.0
     */
    public function capitalizeText()
    {
        // Verifies the AJAX request
        if (check_ajax_referer('capitalizeText', 'nonce', false) === false)
        {
            wp_send_json_error('Failed nonce', 403); // Sends json_encoded success=false.
        }

        // Sanitize values
        $text = sanitize_text_field($_POST['text']);

        // Generate response data
        $responseData = array(
            'capitalizedText' => strtoupper($text)
        );

        // Send a JSON response back to an AJAX request, and die().
        wp_send_json($responseData, 200);
    }

    /**
     * The Form's HTML code.
     * @since    1.0.0
     * @return  The form's HTML code.
     */
    private function getFormHtml(): string
    {
        return '<div>
                    <label for="capitalized-subject">' . esc_html__('UPS Tracking', 'ups-tracking') . '</label>
                    <p id="capitalized-subject"></p>
                    <form action="' . esc_url($_SERVER['REQUEST_URI']) . '" method="post">
                        <p>' . wp_nonce_field('getFormHtml', 'getFormHtml_nonce', true, false) . '</p>
                        <p>
                            <label for="inquiryNumber">' . esc_html__('Inquiry Number', 'ups-tracking') . '&nbsp;<span class="required">*</span></label>
                            <input type="text" id="inquiryNumber" name="inquiryNumber" value="' . (isset($_POST["inquiryNumber"]) ? esc_html($_POST["inquiryNumber"]) : '') . '" required />
                        </p>
                        <p><input type="submit" name="form-submitted" value="' . esc_html__('Submit', 'ups-tracking') . '"/></p>
                    </form>
                </div>';
    }

    /**
     * Validates and process the submitted data.
     * @since    1.0.0
     */
    private function processFormData(): void
    {
        // Check the Submit button is clicked
        if(isset($_POST['form-submitted']))
        {
            // Verify Nonce
            if (wp_verify_nonce($_POST['getFormHtml_nonce'], 'getFormHtml') !== false)
            {
                $inquiryNumber = $_POST["inquiryNumber"];

                // Process the data.
                $response = UPSTracker::getUpsTracking($inquiryNumber);

                if ($response['Fault']) {
                    $faultResponse = $response['Fault'];
                    $formattedResponse = $this->formatError($faultResponse);
                    echo $formattedResponse;
                    return;
                }

                $trackResponse = $response['TrackResponse'];
                $formattedResponse = $this->formatResponse($trackResponse);
                echo $formattedResponse;
            }
            else
            {
                exit(esc_html__('Failed security check.', 'ups-tracking'));
            }
        }
    }

    private function formatResponse($trackResponse): string
    {
        $html = '<table>';
        $html .= '<th>Status</th>';
        $html .= '<th>Response</th>';

        $response = $trackResponse['Response'];
        $responseStatus = $response['ResponseStatus'];

        $shipment = $trackResponse['Shipment'];
        $packages = $trackResponse['Shipment']['Package'];
        $disclaimer = $trackResponse['Disclaimer'];

        // Response
        $html .= '<tr>';
        $html .= '<td>Response status</td>';
        $html .= '<td>'.$responseStatus['Description'].'</td>';
        $html .= '</tr>';

        // Shipment
        $html .= '<tr>';
        $html .= '<td colspan="2"><strong>Shipment</strong></td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>Shipment type</td>';
        $html .= '<td>'.$shipment['ShipmentType']['Description'].'</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>Shipper number</td>';
        $html .= '<td>'.$shipment['ShipperNumber'].'</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>Shipment service</td>';
        $html .= '<td>'.$shipment['Service']['Description'].'</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>Shipment reference number</td>';
        $html .= '<td>'.$shipment['ReferenceNumber']['Value'].'</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>Pickup date</td>';
        $html .= '<td>'.$shipment['PickupDate'].'</td>';
        $html .= '</tr>';

        // Package
        foreach ($packages as $package) {
            $html .= '<tr>';
            $html .= '<td colspan="2"><strong>Package</strong></td>';
            $html .= '</tr>';

            if ($package['TrackingNumber']) {
                $html .= '<tr>';
                $html .= '<td>Tracking number</td>';
                $html .= '<td>' . $package['TrackingNumber'] . '</td>';
                $html .= '</tr>';
            }

            // Activity
            if ($package['Activity']) {
                $html .= '<tr>';
                $html .= '<td colspan="2"><strong>Activities</strong></td>';
                $html .= '</tr>';

                foreach ($package['Activity'] as $activity) {
                    $html .= '<tr>';
                    $html .= '<td>' . $activity['Date'] . ' / ' . $activity['Time'] . '</td>';
                    $html .= '<td>' . $activity['Status']['Description'] . '</td>';
                    $html .= '</tr>';
                }
            }
        }

        // Disclaimer
        $html .= '<tr>';
        $html .= '<td colspan="2"><strong>Disclaimer</strong></td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td colspan="2">'.$disclaimer.'</td>';
        $html .= '</tr>';

        $html .= '</table>';

        return $html;
    }

    private function formatError($faultResponse): string
    {
        $html = '<table>';
        $html .= '<th>Error Code</th>';
        $html .= '<th>Description</th>';

        $errors = $faultResponse['detail']['Errors'];

        // Errors
        foreach ($errors as $error) {
            $primaryErrorCode = $error['PrimaryErrorCode'];

            $html .= '<tr>';
            $html .= '<td>'.$primaryErrorCode['Code'].'</td>';
            $html .= '<td>'.$primaryErrorCode['Description'].'</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';

        return $html;
    }
}
