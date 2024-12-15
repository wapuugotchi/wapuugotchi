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
 * Class TourQuestContent
 */
class TourDashboard {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 25, 1 );
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
					->set_page( 'dashboard' )
					->set_file( 'index.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Welcome Aboard!', 'wapuugotchi' ) )
							->set_text( __( 'Hey there! Welcome to your journey through the WordPress universe! I\'m super excited to guide you through your first steps in WordPress. First, we are going to dive into two essentials: the admin bar and the admin menu. Let\'s go!', 'wapuugotchi' ) )
							->add_target( Target::create() )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Navigation', 'wapuugotchi' ) )
							->set_text( __( 'First, let\'s look at how to navigate the tour. Above this dialog box are the navigation controls, allowing you to move forward or backward, end the tour, or start a demo at key points.', 'wapuugotchi' ) )
							->add_target( Target::create() )
					)
					->add_item(
						Item::create()
							->set_title( __( 'The Admin-Bar', 'wapuugotchi' ) )
							->set_text( __( 'First stop, the "Admin Bar"! This is your quick access lane to key areas and information. You will also get a snapshot of pending updates and comments here.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#wpadminbar' )->set_overlay( '#wpadminbar' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'WapuuGotchi Bar', 'wapuugotchi' ) )
							->set_text( __( 'I also have a menu item here. Here, you can restart the tour we’re currently on—or just specific parts of it!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#wp-admin-bar-wapuugotchi_admin_bar_menu' )->set_overlay( '#wp-admin-bar-wapuugotchi_admin_bar_menu' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Navigating the website', 'wapuugotchi' ) )
							->set_text( __( 'The "Admin Menu" makes switching between different areas of your website a breeze. You can easily access one of these areas by clicking on a main menu item.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#adminmenuwrap' )->set_overlay( '#adminmenuwrap' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'About submenus', 'wapuugotchi' ) )
							->set_text( __( 'After clicking on a main menu item, you’ll see some submenu items pop up underneath. They\'re like special little tools that let you do things related to the main menu item you clicked on. It\'s super helpful!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#toplevel_page_wapuugotchi' )->set_overlay( '#toplevel_page_wapuugotchi' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tip 1', 'wapuugotchi' ) )
							->set_text( __( 'A small hint: If you want a wider view of your website, you can always collapse the admin menu. Give it a try by clicking the ► button.', 'wapuugotchi' ) )
							->set_freeze( 5500 )
							->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' ) )
							->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_click( '#collapse-button' )->set_delay( 1000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_click( '#collapse-button' )->set_delay( 1000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_click( '#collapse-button' )->set_delay( 1000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_click( '#collapse-button' )->set_delay( 1000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_delay( 500 ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Navigating the website', 'wapuugotchi' ) )
							->set_text( __( 'Let\'s take a closer look at each "Main Menu Item". We\'ll uncover the ins and outs, showing you how every part plays its role in the grand WordPress system. Ready to explore?', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#adminmenuwrap' )->set_overlay( '#adminmenuwrap' ) )
					)
					->set_page( 'dashboard' )
					->set_file( 'index.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Exploring the Dashboard', 'wapuugotchi' ) )
							->set_text( __( 'Let\'s zoom into our first main menu item: the "Dashboard". This is where you\'ll find all the key info from every corner of your website. Let\'s peek inside!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#menu-dashboard' )->set_overlay( '#menu-dashboard' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Landing Page', 'wapuugotchi' ) )
							->set_text( __( 'Our first stop is the "Home" page. This pops up when you log into your WordPress backend.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#menu-dashboard .wp-submenu li a.current' )->set_overlay( '#menu-dashboard' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'The Rundown', 'wapuugotchi' ) )
							->set_text( __( 'This page gives you a summary of everything – new posts, recent comments, and stats from across your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Customize It', 'wapuugotchi' ) )
							->set_text( __( 'You\'ve got the power to tweak your "Home" page. Turn off elements that don\'t spark your interest. It\'s all in your hands! Click the ► button to see how does it work.', 'wapuugotchi' ) )
							->set_freeze( 17000 )
							->add_target( Target::create()->set_focus( 'button#show-settings-link' )->set_overlay( 'button#show-settings-link' ) )
							->add_target( Target::create()->set_focus( 'button#show-settings-link' )->set_overlay( 'button#show-settings-link' )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( 'button#show-settings-link' )->set_overlay( 'button#show-settings-link' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( 'button#show-settings-link[aria-expanded="false"]' )->set_clickable( 2 ) )
							->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#screen-meta' )->set_delay( 250 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#wpcontent' )->set_delay( 1000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#wpcontent' )->set_delay( 3000 )->set_color( '#FF0000' )->set_click( '#wp_welcome_panel-hide' )->set_clickable( 2 )->set_hover( true ) )
							->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#wpcontent' )->set_delay( 3000 )->set_color( '#FF0000' )->set_click( '#wp_welcome_panel-hide' )->set_clickable( 2 )->set_hover( true ) )
							->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#wpcontent' )->set_delay( 3000 )->set_color( '#FF0000' )->set_click( '#wp_welcome_panel-hide' )->set_clickable( 2 )->set_hover( true ) )
							->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#wpcontent' )->set_delay( 1000 )->set_color( '#FF0000' )->set_click( '#wp_welcome_panel-hide' )->set_clickable( 2 )->set_hover( true ) )
							->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#wpcontent' )->set_delay( 1000 )->set_color( '#FF0000' )->set_click( '#wp_welcome_panel-hide' )->set_clickable( 2 )->set_hover( true ) )
							->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#wpcontent' )->set_delay( 1000 )->set_color( '#FF0000' )->set_click( '#wp_welcome_panel-hide' )->set_clickable( 2 )->set_hover( true ) )
							->add_target( Target::create()->set_focus( '#screen-meta' )->set_overlay( '#screen-meta' )->set_delay( 2000 )->set_color( '#FFCC00' ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
