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
class OptionsReading {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 750, 1 );
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
					->set_page( 'options-reading' )
					->set_file( 'options-reading.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Reading', 'wapuugotchi' ) )
							->set_text( __( 'The "Reading" page allows you to set basic display settings for your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-settings .wp-submenu li a.current' )->set_overlay( '#menu-settings' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'Here, you can set up the settings for your homepage and posts page. You can also decide how many posts should be displayed on the homepage.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Homepage', 'wapuugotchi' ) )
							->set_text( __( 'Setting a static homepage allows you to customize the front page of your website. This is particularly useful if you\'re running a business website or a landing page.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#front-static-pages' )->set_overlay( '#front-static-pages' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Search Engines', 'wapuugotchi' ) )
							->set_text( __( 'You might notice that despite using SEO plugins, visitors aren\'t coming through search engines. This could be because you\'ve disabled search engine indexing here.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
