<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Filters;

use Wapuugotchi\Models\OnboardingItem as Item;
use Wapuugotchi\Models\OnboardingPage as Page;
use Wapuugotchi\Onboarding\Data\OnboardingPage;
use Wapuugotchi\Wapuugotchi\OnboardingTarget as Target;
use function Wapuugotchi\Onboarding\Data\__;
use function Wapuugotchi\Onboarding\Data\add_filter;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestContent
 */
class SiteHealthData {

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
						->set_page( 'site-health' )
						->set_file( 'site-health.php' )
						->add_item(
							Item::create()
								->set_title( __( 'Site Health', 'wapuugotchi' ) )
								->set_text( __( 'In the "Site Health" page, you can check out the overall health of your website.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#menu-tools .wp-submenu li a.current' )->set_overlay( '#menu-tools' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Status', 'wapuugotchi' ) )
								->set_text( __( 'Right off the bat, you can see how your website\'s performance and security are doing. Here, you can also spot any issues that need to be fixed.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Report', 'wapuugotchi' ) )
								->set_text( __( 'If you click on the "Report" tab, you\'ll get a detailed breakdown of the technical aspects of your website. Take a look if you\'re in the mood to be completely baffled!', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '.health-check-tabs-wrapper a:not(.active)' )->set_overlay( '.health-check-tabs-wrapper a:not(.active)' ) )
						);

		return array_merge( $tour, array( $page ) );
	}
}
