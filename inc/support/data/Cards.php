<?php
/**
 * The Cards Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Support\Data;

use Wapuugotchi\Support\Models\Card;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Cards
 *
 * Provides support card data for the support page.
 */
class Cards {
	/**
	 * Get support cards.
	 *
	 * @return array
	 */
	public static function get_cards() {
		return array(
			Card::create()
				->set_title( __( '🤝 Contact us', 'wapuugotchi' ) )
				->set_description( __( 'Questions, feedback, or need a hand with WapuuGotchi? Send us a note.', 'wapuugotchi' ) )
				->set_meta( __( 'Email: support@wapuugotchi.com', 'wapuugotchi' ) )
				->set_button(
					array(
						'label' => __( 'Send email', 'wapuugotchi' ),
						'href'  => 'mailto:support@wapuugotchi.com',
						'type'  => 'primary',
					)
				),
			Card::create()
				->set_title( __( '🐞 Found a bug?', 'wapuugotchi' ) )
				->set_description( __( 'Oops, that should not happen. Help us squash it fast:', 'wapuugotchi' ) )
				->set_list(
					array(
						__( 'What were you trying to do?', 'wapuugotchi' ),
						__( 'Steps to reproduce', 'wapuugotchi' ),
						__( 'Your WordPress, PHP & WapuuGotchi versions', 'wapuugotchi' ),
					)
				)
				->set_button(
					array(
						'label' => __( 'Report a bug', 'wapuugotchi' ),
						'href'  => 'https://github.com/wapuugotchi/wapuugotchi/issues/new?type=bug',
						'type'  => 'secondary',
					)
				),
			Card::create()
				->set_title( __( '💡 Ideas & feature wishes', 'wapuugotchi' ) )
				->set_description( __( 'Got an idea for new items, missions, or improvements? Tell us!', 'wapuugotchi' ) )
				->set_button(
					array(
						'label' => __( 'Share an idea', 'wapuugotchi' ),
						'href'  => 'https://github.com/wapuugotchi/wapuugotchi/issues/new?type=feature',
						'type'  => 'secondary',
					)
				),
			Card::create()
				->set_title( __( '💛 Support WapuuGotchi', 'wapuugotchi' ) )
				->set_description( __( 'WapuuGotchi stays free, but art and graphics cost money. If you want, you can support us:', 'wapuugotchi' ) )
				->set_highlight( true )
				->set_button(
					array(
						'label' => __( 'Buy me a coffee', 'wapuugotchi' ),
						'href'  => 'https://www.buymeacoffee.com/wapuugotchi',
						'type'  => 'primary',
					)
				),
		);
	}
}
