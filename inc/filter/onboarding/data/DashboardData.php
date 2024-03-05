<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Data;

use Wapuugotchi\Models\OnboardingItem as Item;
use Wapuugotchi\Models\OnboardingPage as Page;
use Wapuugotchi\Wapuugotchi\Onboarding;
use Wapuugotchi\Wapuugotchi\OnboardingTarget as Target;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestContent
 */
class DashboardData {

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
						->set_page( 'dashboard' )
						->set_file( 'index.php' )
						->add_item(
							Item::create()
								->set_title( __( 'Exploring the Dashboard', 'wapuugotchi' ) )
								->set_text( __( 'Let\'s zoom into our first area: the "Dashboard". This is where you\'ll find all the key info from every corner of your site. Let\'s peek inside!', 'wapuugotchi' ) )
								->add_target( Target::create()->set_focus( '#menu-dashboard' )->set_overlay( '#menu-dashboard' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Landing Page', 'wapuugotchi' ) )
								->set_text( __( 'Our first stop is the "Home" section. This pops up when you log into your WordPress backend.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_focus( '#menu-dashboard .wp-submenu li a.current' )->set_overlay( '#menu-dashboard' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'The Rundown', 'wapuugotchi' ) )
								->set_text( __( 'Your homepage gives you a summary of everything – new posts, recent comments, and stats from across your site.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Customize It', 'wapuugotchi' ) )
								->set_text( __( 'You\'ve got the power to tweak your homepage. Turn off sections that don\'t spark your interest. It\'s all in your hands!', 'wapuugotchi' ) )
								->set_freeze( 20000 )
								->add_target( Target::create()->set_focus( 'button#show-settings-link' )->set_overlay( 'button#show-settings-link' ) )
								->add_target( Target::create()->set_focus( 'button#show-settings-link' )->set_overlay( 'button#show-settings-link' )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( 'button#show-settings-link' )->set_overlay( 'button#show-settings-link' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( 'button#show-settings-link[aria-expanded="false"]' )->set_clickable( 2 ) )
								->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#screen-meta' )->set_delay( 250 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#wpcontent' )->set_delay( 5000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#wpcontent' )->set_delay( 2000 )->set_color( '#FF0000' )->set_click( '#wp_welcome_panel-hide' )->set_clickable( 2 )->set_hover( true ) )
								->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#wpcontent' )->set_delay( 2000 )->set_color( '#FF0000' )->set_click( '#wp_welcome_panel-hide' )->set_clickable( 2 )->set_hover( true ) )
								->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#wpcontent' )->set_delay( 2000 )->set_color( '#FF0000' )->set_click( '#wp_welcome_panel-hide' )->set_clickable( 2 )->set_hover( true ) )
								->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#wpcontent' )->set_delay( 2000 )->set_color( '#FF0000' )->set_click( '#wp_welcome_panel-hide' )->set_clickable( 2 )->set_hover( true ) )
								->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#screen-meta' )->set_delay( 4000 )->set_color( '#FFCC00' ) )
						);

		return array_merge( $tour, array( $page ) );
	}
}
