<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Data;

use Wapuugotchi\Onboarding\Models\Guide;
use Wapuugotchi\Onboarding\Models\Item;
use Wapuugotchi\Onboarding\Models\Target;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class QuestContent
 */
class Plugins {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 375, 1 );
	}

	/**
	 * Init and add a guide item to the array of items.
	 *
	 * @param array $tour Array of onboarding objects.
	 *
	 * @return Guide[]
	 */
	public function add_wapuugotchi_filter( $tour ) {
		$page = Guide::create()
					->set_page( 'plugins' )
					->set_file( 'plugins.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'We are currently in the submenu of the "Plugins" main menu item. Here, you can search for, install, and activate new plugins.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-plugins' )->set_overlay( '#menu-plugins' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Installed Plugins', 'wapuugotchi' ) )
							->set_text( __( 'The "Installed Plugins" page lets you manage the plugins you\'ve already installed.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-plugins .wp-submenu li a.current' )->set_overlay( '#menu-plugins' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Introduction', 'wapuugotchi' ) )
							->set_text( __( 'Plugins extend the functionality of your WordPress website. That can be things like contact forms, galleries, slideshows, SEO tools, security features, and much more.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Plugin Overview', 'wapuugotchi' ) )
							->set_text( __( 'In the Plugin Overview, you can see and manage all your installed plugins. Here, you can also easily activate or deactivate the plugins you\'re using.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#the-list' )->set_overlay( '#the-list' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Search for Specific Plugins', 'wapuugotchi' ) )
							->set_text( __( 'You also have the option to search for specific plugins. This is handy when you have many plugins installed.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.search-box' )->set_overlay( '.search-box' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Installing Plugins', 'wapuugotchi' ) )
							->set_text( __( 'It\'s best to install plugins only from the official WordPress Plugin Library. Not only is it a trustworthy source, but you also get benefits like automatic updates, community support, and much more.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'a.page-title-action' )->set_overlay( 'a.page-title-action' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Updating Plugins', 'wapuugotchi' ) )
							->set_text( __( 'Developers regularly release updates for their plugins to fix bugs, close security gaps, or add new features. It\'s important to keep your plugins up-to-date.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#the-list tr' )->set_overlay( '#the-list tr' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Summary', 'wapuugotchi' ) )
							->set_text( __( 'There are incredibly many plugins, and you\'ll find that there\'s a plugin solution for almost every problem!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
