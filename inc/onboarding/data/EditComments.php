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
class EditComments {

	/**
	 * 'Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 275, 1 );
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
					->set_page( 'edit-comments' )
					->set_file( 'edit-comments.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Comments', 'wapuugotchi' ) )
							->set_text( __( 'Now, I\'m going to tell you everything I know about the "Comments" main menu item. This is the place where all the conversations on your website happen.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-comments' )->set_overlay( '#menu-comments' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Why Comments?', 'wapuugotchi' ) )
							->set_text( __( 'This page is a key tool for engaging with your visitors. Here, you can respond to feedback and moderate discussions.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'This is where you\'ll find a list of all the comments left by visitors on your website, including the comment text, the author\'s name, the post they commented on, and the date.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'table.wp-list-table' )->set_overlay( 'table.wp-list-table' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Author', 'wapuugotchi' ) )
							->set_text( __( 'This field lets you quickly see who left the comment. For registered visitors, their email address is also shown.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'td.author' )->set_overlay( 'td.author' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Comment Status', 'wapuugotchi' ) )
							->set_text( __( 'The "Comment" field displays the actual content of the comment left by a visitor on your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'td.comment' )->set_overlay( 'td.comment' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Related Post', 'wapuugotchi' ) )
							->set_text( __( 'This shows which post the comment is referring to, helping you understand the context.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'td.response' )->set_overlay( 'td.response' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Comment Date', 'wapuugotchi' ) )
							->set_text( __( 'The "Date" field indicates when the comment was left on your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'td.date' )->set_overlay( 'td.date' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Changing Comment Status', 'wapuugotchi' ) )
							->set_text( __( 'A comment can be "Pending", "Approved", "Trash", or "Spam". Pending comments won\'t show on your website until you approve them.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'ul.subsubsub' )->set_overlay( 'ul.subsubsub' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Using Search', 'wapuugotchi' ) )
							->set_text( __( 'The search function lets you look for specific comments based on keywords, usernames, email addresses, or other relevant info.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.search-box' )->set_overlay( '.search-box' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tip 1', 'wapuugotchi' ) )
							->set_text( __( 'A quick hint: Want to quickly approve or trash a comment? Hover over it and click the corresponding action.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#the-comment-list tr' )->set_overlay( '#the-comment-list tr' )->set_hover( true ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
