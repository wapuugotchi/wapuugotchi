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
							->set_title( __( 'Welcome', 'wapuugotchi' ) )
							->set_text( __( 'Welcome to your WordPress adventure! I\'m thrilled to guide you through the initial steps of setting up your site. Let’s dive in immediately!', 'wapuugotchi' ) )
							->add_target( Target::create() )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Admin Bar', 'wapuugotchi' ) )
							->set_text( __( 'First up, the Admin Bar – your gateway to key areas and updates. It provides quick access to essential information, including pending updates and recent comments.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#wpadminbar' )->set_overlay( '#wpadminbar' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Side Navigation', 'wapuugotchi' ) )
							->set_text( __( 'Navigate your site with ease using the Side Navigation. It\'s structured into several sections, each housing key features and settings for your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#adminmenuwrap' )->set_overlay( '#adminmenuwrap' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Dashboard', 'wapuugotchi' ) )
							->set_text( __( 'The Dashboard is your control center, offering a snapshot of your site\'s activity. It aggregates critical information from all sections for quick access.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#menu-dashboard' )->set_overlay( '#menu-dashboard' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Home Page', 'wapuugotchi' ) )
							->set_text( __( 'The Home Page is where your WordPress journey starts after logging in. It\'s the front line of your site management, offering a quick overview of your site\'s status.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#menu-dashboard .wp-submenu li a.current' )->set_overlay( '#menu-dashboard' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Explanation', 'wapuugotchi' ) )
							->set_text( __( 'Your Home Page acts as a central hub, summarizing key insights from your site, including the latest posts, comments, and important statistics.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Customization', 'wapuugotchi' ) )
							->set_text( __( 'Tailor your Home Page to fit your needs. Disable sections you find irrelevant and streamline your dashboard to focus on what matters most to you.', 'wapuugotchi' ) )
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
