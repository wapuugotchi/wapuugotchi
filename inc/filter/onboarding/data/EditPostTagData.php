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
class EditPostTagData {

	/**
	 * 'Constructor' of the class
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
						->set_page( 'edit-post_tag' )
						->set_file( 'edit-tags.php?taxonomy=post_tag' )
						->add_item(
							Item::create()
								->set_title( __( 'Tags', 'wapuugotchi' ) )
								->set_text( __( 'Welcome to the "Tags" section! Tags let you enhance your posts with additional keywords or phrases.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#menu-posts .wp-submenu li a[href=\'edit-tags.php?taxonomy=post_tag\']' )->set_overlay( '#menu-posts' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Differentiating', 'wapuugotchi' ) )
								->set_text( __( 'Unlike categories, which sort posts into broad thematic areas, tags provide finer detail, allowing you to link specific topics, keywords, or key phrases to your posts.', 'wapuugotchi' ) )
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
								->set_text( __( 'The overview page shows all your created tags. You\'ll also see info on how often your tags are used in your posts.', 'wapuugotchi' ) )
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
