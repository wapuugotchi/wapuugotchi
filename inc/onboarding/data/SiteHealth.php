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
class SiteHealth {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 575, 1 );
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
