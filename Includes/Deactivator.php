<?php

declare( strict_types=1 );

namespace UpsTracking\Includes;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @link       https://github.com/aarsla/Ups-Tracker
 * @since      1.0.0
 * @package    Ups-Tracker
 * @subpackage Ups-Tracker/Includes
 * @author     Aid Arslanagic <aarsla@gmail.com>
 */
class Deactivator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate(): void {

	}
}
