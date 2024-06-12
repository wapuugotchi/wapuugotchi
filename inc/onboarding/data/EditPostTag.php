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
class EditPostTag {

	/**
	 * 'Constructor' of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 150, 1 );
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
					->set_page( 'edit-post_tag' )
					->set_file( 'edit-tags.php?taxonomy=post_tag' )
					->add_item(
						Item::create()
							->set_title( __( 'Tags', 'wapuugotchi' ) )
							->set_text( __( 'This is the "Tags" page! Tags let you enhance your posts with additional keywords or phrases. That way, your content can be found and searched through easier!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-posts .wp-submenu li a[href=\'edit-tags.php?taxonomy=post_tag\']' )->set_overlay( '#menu-posts' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Differentiating', 'wapuugotchi' ) )
							->set_text( __( 'Unlike categories, which group posts into broad themes, tags give more specific details. They help you connect particular topics, keywords, or phrases to your posts.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Creating Tags', 'wapuugotchi' ) )
							->set_text( __( 'You can create tags that match the specific content of your posts. These can be single words or short phrases that reflect the main concepts or themes of the post.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#col-left' )->set_overlay( '#col-left' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'The overview section shows all your created tags. You\'ll also see info on how often your tags are used in your posts.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#col-right' )->set_overlay( '#col-right' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'SEO Tip', 'wapuugotchi' ) )
							->set_text( __( 'Tags are a key part of Search Engine Optimization (SEO). They help search engines better understand and index the content of your posts.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
