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
 * Class TourTourData
 */
class TourOrder {

	/**
	 * Init and add a guide item to the array of items.
	 *
	 * @param array $elements Array of onboarding objects.
	 *
	 * @return array
	 */
	public static function add_wapuugotchi_filter( $elements ) {
		$element = array(
			'\Wapuugotchi\Onboarding\Data\TourDashboard',
			'\Wapuugotchi\Onboarding\Data\TourUpdateCore',
			'\Wapuugotchi\Onboarding\Data\TourEditPost',
			'\Wapuugotchi\Onboarding\Data\TourPost',
			'\Wapuugotchi\Onboarding\Data\TourEditCategory',
			'\Wapuugotchi\Onboarding\Data\TourEditPostTag',
			'\Wapuugotchi\Onboarding\Data\TourUpload',
			'\Wapuugotchi\Onboarding\Data\TourMedia',
			'\Wapuugotchi\Onboarding\Data\TourEditPage',
			'\Wapuugotchi\Onboarding\Data\TourPage',
			'\Wapuugotchi\Onboarding\Data\TourEditComments',
			'\Wapuugotchi\Onboarding\Data\TourThemes',
			'\Wapuugotchi\Onboarding\Data\TourThemeInstall',
			'\Wapuugotchi\Onboarding\Data\TourSiteEditor',
			'\Wapuugotchi\Onboarding\Data\TourPlugins',
			'\Wapuugotchi\Onboarding\Data\TourPluginInstall',
			'\Wapuugotchi\Onboarding\Data\TourUsers',
			'\Wapuugotchi\Onboarding\Data\TourUser',
			'\Wapuugotchi\Onboarding\Data\TourProfile',
			'\Wapuugotchi\Onboarding\Data\TourTools',
			'\Wapuugotchi\Onboarding\Data\TourImport',
			'\Wapuugotchi\Onboarding\Data\TourExport',
			'\Wapuugotchi\Onboarding\Data\TourSiteHealth',
			'\Wapuugotchi\Onboarding\Data\TourExportPersonalData',
			'\Wapuugotchi\Onboarding\Data\TourErasePersonalData',
			'\Wapuugotchi\Onboarding\Data\TourThemeEditor',
			'\Wapuugotchi\Onboarding\Data\TourPluginEditor',
			'\Wapuugotchi\Onboarding\Data\TourOptionsGeneral',
			'\Wapuugotchi\Onboarding\Data\TourOptionsWriting',
			'\Wapuugotchi\Onboarding\Data\TourOptionsReading',
			'\Wapuugotchi\Onboarding\Data\TourOptionsDiscussion',
			'\Wapuugotchi\Onboarding\Data\TourOptionsMedia',
			'\Wapuugotchi\Onboarding\Data\TourOptionsPermalink',
			'\Wapuugotchi\Onboarding\Data\TourOptionsPrivacy',
			'\Wapuugotchi\Onboarding\Data\TourWapuugotchiShop',
			'\Wapuugotchi\Onboarding\Data\TourWapuugotchiQuest',
		);

		return array_merge( $elements, $element );
	}
}
