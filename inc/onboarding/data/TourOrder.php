<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class TourData
 */
class TourOrder {

	/**
	 * Init and add a guide item to the array of items.
	 *
	 * @param array $elements Array of onboarding objects.
	 *
	 * @return Guide[]
	 */
	public static function add_wapuugotchi_filter( $elements ) {
		$element = array(
			'\Wapuugotchi\Onboarding\Data\WapuugotchiTour',
			'\Wapuugotchi\Onboarding\Data\Dashboard',
			'\Wapuugotchi\Onboarding\Data\UpdateCore',
			'\Wapuugotchi\Onboarding\Data\EditPost',
			'\Wapuugotchi\Onboarding\Data\Post',
			'\Wapuugotchi\Onboarding\Data\EditCategory',
			'\Wapuugotchi\Onboarding\Data\EditPostTag',
			'\Wapuugotchi\Onboarding\Data\Upload',
			'\Wapuugotchi\Onboarding\Data\Media',
			'\Wapuugotchi\Onboarding\Data\EditPage',
			'\Wapuugotchi\Onboarding\Data\Page',
			'\Wapuugotchi\Onboarding\Data\EditComments',
			'\Wapuugotchi\Onboarding\Data\Themes',
			'\Wapuugotchi\Onboarding\Data\ThemeInstall',
			'\Wapuugotchi\Onboarding\Data\SiteEditor',
			'\Wapuugotchi\Onboarding\Data\Plugins',
			'\Wapuugotchi\Onboarding\Data\PluginInstall',
			'\Wapuugotchi\Onboarding\Data\Users',
			'\Wapuugotchi\Onboarding\Data\User',
			'\Wapuugotchi\Onboarding\Data\Profile',
			'\Wapuugotchi\Onboarding\Data\Tools',
			'\Wapuugotchi\Onboarding\Data\Import',
			'\Wapuugotchi\Onboarding\Data\Export',
			'\Wapuugotchi\Onboarding\Data\SiteHealth',
			'\Wapuugotchi\Onboarding\Data\ExportPersonalData',
			'\Wapuugotchi\Onboarding\Data\ErasePersonalData',
			'\Wapuugotchi\Onboarding\Data\ThemeEditor',
			'\Wapuugotchi\Onboarding\Data\PluginEditor',
			'\Wapuugotchi\Onboarding\Data\OptionsGeneral',
			'\Wapuugotchi\Onboarding\Data\OptionsWriting',
			'\Wapuugotchi\Onboarding\Data\OptionsReading',
			'\Wapuugotchi\Onboarding\Data\OptionsDiscussion',
			'\Wapuugotchi\Onboarding\Data\OptionsMedia',
			'\Wapuugotchi\Onboarding\Data\OptionsPermalink',
			'\Wapuugotchi\Onboarding\Data\OptionsPrivacy',
			'\Wapuugotchi\Onboarding\Data\WapuugotchiShop',
			'\Wapuugotchi\Onboarding\Data\WapuugotchiQuest',
		);

		return array_merge( $elements, $element );
	}
}
