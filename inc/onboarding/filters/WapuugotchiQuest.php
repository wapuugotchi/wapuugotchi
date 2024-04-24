<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Filters;

use Wapuugotchi\Onboarding\Models\Item;
use Wapuugotchi\Onboarding\Models\Guide;
use Wapuugotchi\Onboarding\Models\Target;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestContent
 */
class WapuugotchiQuest {

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
		$page = Guide::create()
		            ->set_page( 'wapuugotchi_page_wapuugotchi__quest' )
		            ->set_file( 'admin.php?page=wapuugotchi__quests' )
		            ->add_item(
			            Item::create()
			                ->set_title( __( 'Task Overview', 'wapuugotchi' ) )
			                ->set_text( __( 'This page, "Tasks", provides an overview of the tasks you\'ve completed and those still awaiting your attention.', 'wapuugotchi' ) )
			                ->add_target( Target::create()->set_active( true )->set_focus( '#toplevel_page_wapuugotchi' )->set_overlay( '#toplevel_page_wapuugotchi' ) )
		            )
		            ->add_item(
			            Item::create()
			                ->set_title( __( 'Overview', 'wapuugotchi' ) )
			                ->set_text( __( 'On the overview page, you can see all tasks. It shows which tasks you\'ve completed and which ones remain. Additionally, you can see how many pearls you\'ll earn for completing each task.', 'wapuugotchi' ) )
			                ->add_target( Target::create()->set_active( true )->set_focus( '#wapuugotchi-app' )->set_overlay( '#wapuugotchi-app' ) )
		            )
		            ->add_item(
			            Item::create()
			                ->set_title( __( 'Conclusion!!!', 'wapuugotchi' ) )
			                ->set_text( __( 'Guess what? We\'re done! I\'ve shared everything I know with you. I hope you had some fun and learned a bit along the way. I\'m glad you stuck with me until the end!', 'wapuugotchi' ) )
			                ->add_target( Target::create()->set_active( true ) )
		            )
		            ->add_item(
			            Item::create()
			                ->set_title( __( 'Feedback', 'wapuugotchi' ) )
			                ->set_text( __( 'I would be thrilled if you could leave some feedback for my developers. It helps them improve me and better assist you in the future.', 'wapuugotchi' ) )
			                ->add_target( Target::create()->set_active( true ) )
		            );

		return array_merge( $tour, array( $page ) );

	}
}
