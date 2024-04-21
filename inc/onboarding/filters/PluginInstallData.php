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
use Wapuugotchi\Wapuugotchi\Onboarding;
use Wapuugotchi\Wapuugotchi\OnboardingTarget as Target;
use function Wapuugotchi\Onboarding\Data\__;
use function Wapuugotchi\Onboarding\Data\add_filter;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestContent
 */
class PluginInstallData {

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
						->set_page( 'plugin-install' )
						->set_file( 'plugin-install.php' )
							->add_item(
								Item::create()
									->set_title( __( 'Introduction', 'wapuugotchi' ) )
									->set_text( __( 'Welcome to the "Install" page. Here, you can search for, install, and activate new plugins.', 'wapuugotchi' ) )
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
