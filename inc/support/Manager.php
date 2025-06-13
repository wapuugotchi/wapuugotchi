<?php
/**
 * The Log Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Support;

use Wapuugotchi\Quest\Data\AutoMessage;
use Wapuugotchi\Quest\Data\QuestContent;
use Wapuugotchi\Quest\Data\QuestDate;
use Wapuugotchi\Quest\Data\QuestPlugin;
use Wapuugotchi\Quest\Data\QuestStart;
use Wapuugotchi\Quest\Data\QuestTheme;
use Wapuugotchi\Quest\Handler\QuestHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Log
 */
class Manager {

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_add_submenu', array( Menu::class, 'wapuugotchi_add_submenu' ), 20 );
	}
}
