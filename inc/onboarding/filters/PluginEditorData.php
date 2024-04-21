<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Filters;

use Wapuugotchi\Models\OnboardingItem as Item;
use Wapuugotchi\Models\OnboardingPage as Page;
use Wapuugotchi\Onboarding\Data\OnboardingPage;
use Wapuugotchi\Wapuugotchi\OnboardingTarget as Target;
use function Wapuugotchi\Onboarding\Data\__;
use function Wapuugotchi\Onboarding\Data\add_filter;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestContent
 */
class PluginEditorData {

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
		$page[] = Page::create()
						->set_page( 'plugin-editor' )
						->set_file( 'plugin-editor.php' )
						->add_item(
							Item::create()
								->set_title( __( 'Edit Plugins', 'wapuugotchi' ) )
								->set_text( __( 'This page allows you to edit the files of your plugins.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#menu-tools .wp-submenu li a.current' )->set_overlay( '#menu-tools' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Overview', 'wapuugotchi' ) )
								->set_text( __( 'The same principles apply as with editing themes. On this page, you can make direct changes to the files of your plugins. You should have some programming knowledge if you\'re planning to work here.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Warning', 'wapuugotchi' ) )
								->set_text( __( 'Heads up! Editing files can damage your website. If you\'re not certain about what you\'re doing, it\'s better to avoid tinkering with this.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
						);

		return array_merge( $tour, array( $page ) );
	}
}
