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
class EditCategory {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 125, 1 );
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
					->set_page( 'edit-category' )
					->set_file( 'edit-tags.php?taxonomy=category' )
					->add_item(
						Item::create()
							->set_title( __( 'Categories', 'wapuugotchi' ) )
							->set_text( __( 'This is the "Categories" page! These are super handy for organizing and structuring your content, making it easier for visitors to find relevant info.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-posts .wp-submenu li a.current' )->set_overlay( '#menu-posts' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Creating New Ones', 'wapuugotchi' ) )
							->set_text( __( 'You can create new categories to group your posts thematically. This not only makes navigation a breeze but also boosts SEO, helping users find your website when they search.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#col-left' )->set_overlay( '#col-left' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Hierarchies', 'wapuugotchi' ) )
							->set_text( __( 'Categories can have a hierarchy. Set up subcategories for even more precise organization of your content.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.term-parent-wrap' )->set_overlay( '.term-parent-wrap' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview Page', 'wapuugotchi' ) )
							->set_text( __( 'The overview page not only shows all your categories but also their hierarchical relationships. Check out how often your categories are used in your posts.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#col-right' )->set_overlay( '#col-right' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'In Summary', 'wapuugotchi' ) )
							->set_text( __( 'Overall, the "Categories" page offers an effective way to enhance the organization and findability of content on your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
