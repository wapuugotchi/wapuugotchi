<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Filters;

use Wapuugotchi\Onboarding\Models\Item;
use Wapuugotchi\Onboarding\Models\Guide;
use Wapuugotchi\Onboarding\Models\Target;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestContent
 */
class OptionsWriting {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ) );
	}

	/**
	 * Initialization filter for OnboardingData
	 *
	 * @param array $tour Array of onboarding objects.
	 *
	 * @return array|OnboardingPage[]
	 */
	public function add_wapuugotchi_filter( $tour ) {
		$page = Guide::create()
		            ->set_page( 'options-writing' )
		            ->set_file( 'options-writing.php' )
		            ->add_item(
			            Item::create()
			                ->set_title( __( 'Writing', 'wapuugotchi' ) )
			                ->set_text( __( 'The "Writing" page helps you with creating posts and articles.', 'wapuugotchi' ) )
			                ->add_target( Target::create()->set_active( true )->set_focus( '#menu-settings .wp-submenu li a.current' )->set_overlay( '#menu-settings' ) )
		            )
		            ->add_item(
			            Item::create()
			                ->set_title( __( 'Overview', 'wapuugotchi' ) )
			                ->set_text( __( 'Setting up these options correctly according to your needs can enhance user-friendliness and efficiency when composing content.', 'wapuugotchi' ) )
			                ->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
		            );

		return array_merge( $tour, array( $page ) );

	}
}
