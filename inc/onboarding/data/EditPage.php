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
class EditPage {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 225, 1 );
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
					->set_page( 'edit-page' )
					->set_file( 'edit.php?post_type=page' )
					->add_item(
						Item::create()
							->set_title( __( 'Pages Overview', 'wapuugotchi' ) )
							->set_text( __( 'We\'re now exploring the submenu of the "Pages" main menu item. This is where you manage all your static content.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-pages' )->set_overlay( '#menu-pages' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'All Pages', 'wapuugotchi' ) )
							->set_text( __( '"All Pages" lets you view, organize, and manage your pages all in one spot.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-pages .wp-submenu li a[href=\'edit.php?post_type=page\']' )->set_overlay( '#menu-pages' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'About Pages', 'wapuugotchi' ) )
							->set_text( __( 'As mentioned, "Pages" are static content. Unlike "Posts", they\'re more permanent, like your "About Us" or "Contact" pages.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'This page overview gives you a good look at all the pages you\'ve created. Plus, you can organize and manage them from here.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'table.wp-list-table' )->set_overlay( 'table.wp-list-table' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Titles', 'wapuugotchi' ) )
							->set_text( __( 'This column shows the titles of all pages. Click a title to edit the page and change its content.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'td.title' )->set_overlay( 'td.title' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Author', 'wapuugotchi' ) )
							->set_text( __( 'This column shows who created the page. For multiple authors, it\'ll display their names.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'td.author' )->set_overlay( 'td.author' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Publish Date', 'wapuugotchi' ) )
							->set_text( __( 'This column shows the date when the page was created or last edited.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'td.date' )->set_overlay( 'td.date' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Quick Overview', 'wapuugotchi' ) )
							->set_text( __( 'Hover over a page to see a menu for quick actions like editing. Give it a try! Just move your cursor over the menu above!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#the-list tr' )->set_overlay( '#the-list tr' )->set_hover( 1 ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Sorting and Filtering', 'wapuugotchi' ) )
							->set_text( __( 'You can sort your pages by different criteria, like date. There are also filtering options to display specific types of pages, like drafts.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.tablenav.top' )->set_overlay( '.tablenav.top' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Search', 'wapuugotchi' ) )
							->set_text( __( 'The search bar lets you look for specific pages, which is super handy if you have lots of them.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.search-box' )->set_overlay( '.search-box' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Create', 'wapuugotchi' ) )
							->set_text( __( 'Behind the "Create" button, you can start crafting new content for your website. It\'ll guide you through the process step by step!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.page-title-action' )->set_overlay( '.page-title-action' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Closing Thoughts', 'wapuugotchi' ) )
							->set_text( __( 'Did you notice I almost said the same thing as in the "Posts" page? Well, that\'s because these pages are pretty similar!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
