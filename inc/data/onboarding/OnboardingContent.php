<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi;

use Wapuugotchi\Models\Target;
use Wapuugotchi\Models\Onboarding;
use Wapuugotchi\Onboarding\Data\DashboardData;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestContent
 */
class OnboardingContent {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		add_action( 'current_screen', array( $this, 'add_onboarding_data' ) );
	}
	/**
	 * Add onboarding data
	 *
	 * @return void
	 */
	public function add_onboarding_data() {
		global $current_screen;
		global $wp_version;

		if ( ! $current_screen ) {
			return;
		}

		$screen    = ucfirst( $current_screen->id );
		$file_name = $screen . 'Data';
		$file_path = plugin_dir_path( __FILE__ ) . $wp_version . '/' . $file_name . '.php';

		if ( file_exists( $file_path ) ) {
			include_once $file_path;
			$class_name = '\\Wapuugotchi\\Onboarding\\Data\\' . $file_name;
			if ( class_exists( $class_name ) ) {
				new $class_name();
			}
		}
	}
}
