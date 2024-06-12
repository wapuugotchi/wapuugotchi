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
class UpdateCore {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 50, 1 );
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
					->set_page( 'update-core' )
					->set_file( 'update-core.php' )
					->add_item(
						Item::create()
							->set_text( __( 'Alright, we\'re now on the "Updates" page of the Dashboard. This is where you\'ll get to keep your website looking sharp and up-to-date.', 'wapuugotchi' ) )
							->set_title( __( 'Updates', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#menu-dashboard .wp-submenu li a.current' )->set_overlay( '#menu-dashboard' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Explanation', 'wapuugotchi' ) )
							->set_text( __( 'So, this is where you can spot any new updates waiting for your website. That includes stuff like themes, plugins you\'ve installed and even the WordPress core itself.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Security Risk', 'wapuugotchi' ) )
							->set_text( __( 'Just a little reminder – staying updated is super important! Old software can be a bit risky, security-wise. These updates aren\'t just about keeping things safe, though; they also bring in cool new features.', 'wapuugotchi' ) )
							->add_target( Target::create() )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Automatic Updates', 'wapuugotchi' ) )
							->set_text( __( 'One last tip – you might want to turn on automatic updates. It\'s a real time-saver and keeps your website on the cutting edge, not to mention secure.', 'wapuugotchi' ) )
							->add_target( Target::create() )
					);

		return array_merge( $tour, array( $page ) );
	}
}
