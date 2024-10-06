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
class WapuugotchiShop {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 850, 1 );
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
					->set_page( 'wapuugotchi_page_wapuugotchi__shop' )
					->set_file( 'admin.php?page=wapuugotchi__shop' )
					->add_item(
						Item::create()
							->set_title( __( 'Wapuugotchi', 'wapuugotchi' ) )
							->set_text( __( 'Welcome to the most entertaining page of all... My page! 😄 Well, it\'s not exactly essential, but it\'s fun! Let\'s take a look.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#toplevel_page_wapuugotchi' )->set_overlay( '#toplevel_page_wapuugotchi' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Customize', 'wapuugotchi' ) )
							->set_text( __( 'On this page, you can customize the appearance. You also have the opportunity to give me a name.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#toplevel_page_wapuugotchi .wp-submenu li a.current' )->set_overlay( '#toplevel_page_wapuugotchi' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'Here, you can adjust my appearance. You can change my hairstyle, make me wear glasses, or dress me in a new t-shirt. I\'m curious to see what you\'ll do!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wapuugotchi-submenu__shop' )->set_overlay( '#wapuugotchi-submenu__shop' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Categories', 'wapuugotchi' ) )
							->set_text( __( 'The items you can equip me with are divided into categories. Check back often, as new items are continuously added!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.wapuugotchi_shop__categories' )->set_overlay( '.wapuugotchi_shop__categories' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Items', 'wapuugotchi' ) )
							->set_text( __( 'Here, you can view all items in a category. Clicking an item will equip it on me. Some items are already unlocked, while others need to be unlocked.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.wapuugotchi_shop__items' )->set_overlay( '.wapuugotchi_shop__items' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Pearls', 'wapuugotchi' ) )
							->set_text( __( 'Here, you can see how many pearls you have. Pearls are the currency used to unlock new items. You earn pearls by completing tasks.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.wapuugotchi_shop__pearls' )->set_overlay( '.wapuugotchi_shop__pearls' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Community Items', 'wapuugotchi' ) )
							->set_text( __( 'Many of the items were created by the WordPress community. You can see the creator\'s name when you want to unlock an item.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.wapuugotchi_shop__item.selected' )->set_overlay( '.wapuugotchi_shop__item.selected' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'How does it work?', 'wapuugotchi' ) )
							->set_text( __( 'Press ► to see how does it work!', 'wapuugotchi' ) )
							->set_freeze( 33000 )
							->add_target( Target::create()->set_focus( '#wapuugotchi-submenu__shop' )->set_overlay( '#wapuugotchi-submenu__shop' ) )
							->add_target( Target::create()->set_focus( '#category_fur' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#category_fur' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( '#category_fur' ) )
							->add_target( Target::create()->set_focus( '.wapuugotchi_shop__item.free' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '.wapuugotchi_shop__item.free' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( '.wapuugotchi_shop__item.free' ) )
							->add_target( Target::create()->set_focus( '#category_balls' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#category_balls' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( '#category_balls' ) )
							->add_target( Target::create()->set_focus( '.wapuugotchi_shop__item.free' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '.wapuugotchi_shop__item.free' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( '.wapuugotchi_shop__item.free' ) )
							->add_target( Target::create()->set_focus( '#category_caps' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#category_caps' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( '#category_caps' ) )
							->add_target( Target::create()->set_focus( '.wapuugotchi_shop__item.free' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '.wapuugotchi_shop__item.free' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( '.wapuugotchi_shop__item.free' ) )
							->add_target( Target::create()->set_focus( '#category_coats' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#category_coats' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( '#category_coats' ) )
							->add_target( Target::create()->set_focus( '.wapuugotchi_shop__item.free' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '.wapuugotchi_shop__item.free' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( '.wapuugotchi_shop__item.free' ) )
							->add_target( Target::create()->set_focus( '#category_items' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#category_items' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( '#category_items' ) )
							->add_target( Target::create()->set_focus( '.wapuugotchi_shop__item.free' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '.wapuugotchi_shop__item.free' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( '.wapuugotchi_shop__item.free' ) )
							->add_target( Target::create()->set_focus( '#category_shoes' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '#category_shoes' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( '#category_shoes' ) )
							->add_target( Target::create()->set_focus( '.wapuugotchi_shop__item.free' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '.wapuugotchi_shop__item.free' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 1200 )->set_color( '#FF0000' )->set_click( '.wapuugotchi_shop__item.free' ) )
							->add_target( Target::create()->set_focus( '#wapuugotchi-submenu__shop' )->set_overlay( '#wapuugotchi-submenu__shop' )->set_delay( 2000 )->set_color( '#FFCC00' ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
