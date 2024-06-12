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
class PluginInstall {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 400, 1 );
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
					->set_page( 'plugin-install' )
					->set_file( 'plugin-install.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Introduction', 'wapuugotchi' ) )
							->set_text( __( 'Welcome to the "Add New Plugin" page. Here, you can search for, install, and activate new plugins.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-plugins .wp-submenu li a.current' )->set_overlay( '#menu-plugins' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'Plugins significantly expand the functionality of your WordPress website. Choosing the right plugins can be crucial for your website\'s success. You\'ll find many articles online that can help you find the best plugins for your needs.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Plugin Selection', 'wapuugotchi' ) )
							->set_text( __( 'As soon as you enter this page, you\'re presented with a selection of plugins. This is really handy since there are more than 60,000 plugins available. This can also help you in finding the right plugins for your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#the-list' )->set_overlay( '#the-list' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Navigation', 'wapuugotchi' ) )
							->set_text( __( 'You can filter by the most popular, latest, and recommended plugins here. This way, you can, for example, follow the favorites of other WordPress users.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.wp-filter ul.filter-links' )->set_overlay( '.wp-filter ul.filter-links' ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
