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
class EditPost {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 75, 1 );
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
					->set_page( 'edit-post' )
					->set_file( 'edit.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Welcome to Posts', 'wapuugotchi' ) )
							->set_text( __( 'Currently, we\'re in the submenu of the "Posts" main menu item. This is where you can create, tweak, and organize all your dynamic content.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#menu-posts' )->set_overlay( '#menu-posts' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'All Posts', 'wapuugotchi' ) )
							->set_text( __( 'In "All Posts", you can view, organize, and manage all your posts at a glance. Additionally, you can start making new posts right from here!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#menu-posts .wp-submenu li a.current' )->set_overlay( '#menu-posts' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview Page', 'wapuugotchi' ) )
							->set_text( __( 'The Overview Page lists all your posts. From here, you can easily create new posts and make quick edits to existing ones.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Post List', 'wapuugotchi' ) )
							->set_text( __( 'The Post List shows you all your posts, along with key details like title, author, and publication date.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( 'table.wp-list-table' )->set_overlay( 'table.wp-list-table' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Titles', 'wapuugotchi' ) )
							->set_text( __( 'The Title column displays the titles of all your posts. Click on any title to edit the post and change its content.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( 'td.title' )->set_overlay( 'td.title' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Authors', 'wapuugotchi' ) )
							->set_text( __( 'The Author column shows who created the post. If there are multiple authors, it\'ll display their usernames.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( 'td.author' )->set_overlay( 'td.author' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Categories', 'wapuugotchi' ) )
							->set_text( __( 'This shows the categories assigned to a post. Categories help organize content on your website in a structured way.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( 'td.categories' )->set_overlay( 'td.categories' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tags', 'wapuugotchi' ) )
							->set_text( __( 'The Tags column lists the tags associated with your posts. Tags make it easier to find content on similar topics.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( 'td.tags' )->set_overlay( 'td.tags' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Dates', 'wapuugotchi' ) )
							->set_text( __( 'The Date column tells you when a post was or will be published. ', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( 'td.date' )->set_overlay( 'td.date' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Quick Access', 'wapuugotchi' ) )
							->set_text( __( 'Hover over a post to see a quick-access menu for important functions. Give it a try! Just move your cursor over the menu above!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#the-list tr' )->set_overlay( '#the-list tr' )->set_hover( 1 ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Sorting and Filtering', 'wapuugotchi' ) )
							->set_text( __( 'Sort your posts by various criteria like date, and use filters to display specific types of posts, like drafts.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '.tablenav.top' )->set_overlay( '.tablenav.top' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Search', 'wapuugotchi' ) )
							->set_text( __( 'Use the search bar to find specific posts by keywords or titles. Super useful when you have lots of posts.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '.search-box' )->set_overlay( '.search-box' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Create', 'wapuugotchi' ) )
							->set_text( __( 'Behind the "Create" button, you can start crafting new content for your website. It\'ll guide you through the process step by step!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '.page-title-action' )->set_overlay( '.page-title-action' ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
