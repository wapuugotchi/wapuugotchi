<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Filters;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class TourData
 */
class TourOrder {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		add_filter( 'wapuugotchi_onboarding_tour_files', array( $this, 'add_wapuugotchi_filter' ) );
	}

	public function add_wapuugotchi_filter( $elements ) {
		$element = array(
			'\Wapuugotchi\Onboarding\Filters\WapuugotchiTour',
			'\Wapuugotchi\Onboarding\Filters\Dashboard',
			'\Wapuugotchi\Onboarding\Filters\UpdateCore',
			'\Wapuugotchi\Onboarding\Filters\EditPost',
			'\Wapuugotchi\Onboarding\Filters\Post',
			'\Wapuugotchi\Onboarding\Filters\EditCategory',
			'\Wapuugotchi\Onboarding\Filters\EditPostTag',
			'\Wapuugotchi\Onboarding\Filters\Upload',
			'\Wapuugotchi\Onboarding\Filters\Media',
			'\Wapuugotchi\Onboarding\Filters\EditPage',
			'\Wapuugotchi\Onboarding\Filters\Page',
			'\Wapuugotchi\Onboarding\Filters\EditComments',
			'\Wapuugotchi\Onboarding\Filters\Themes',
			'\Wapuugotchi\Onboarding\Filters\ThemeInstall',
			'\Wapuugotchi\Onboarding\Filters\SiteEditor',
			'\Wapuugotchi\Onboarding\Filters\Plugins',
			'\Wapuugotchi\Onboarding\Filters\PluginInstall',
			'\Wapuugotchi\Onboarding\Filters\Users',
			'\Wapuugotchi\Onboarding\Filters\User',
			'\Wapuugotchi\Onboarding\Filters\Profile',
			'\Wapuugotchi\Onboarding\Filters\Tools',
			'\Wapuugotchi\Onboarding\Filters\Import',
			'\Wapuugotchi\Onboarding\Filters\Export',
			'\Wapuugotchi\Onboarding\Filters\SiteHealth',
			'\Wapuugotchi\Onboarding\Filters\ExportPersonalData',
			'\Wapuugotchi\Onboarding\Filters\ErasePersonalData',
			'\Wapuugotchi\Onboarding\Filters\ThemeEditor',
			'\Wapuugotchi\Onboarding\Filters\PluginEditor',
			'\Wapuugotchi\Onboarding\Filters\OptionsGeneral',
			'\Wapuugotchi\Onboarding\Filters\OptionsWriting',
			'\Wapuugotchi\Onboarding\Filters\OptionsReading',
			'\Wapuugotchi\Onboarding\Filters\OptionsDiscussion',
			'\Wapuugotchi\Onboarding\Filters\OptionsMedia',
			'\Wapuugotchi\Onboarding\Filters\OptionsPermalink',
			'\Wapuugotchi\Onboarding\Filters\OptionsPrivacy',
			'\Wapuugotchi\Onboarding\Filters\WapuugotchiShop',
			'\Wapuugotchi\Onboarding\Filters\WapuugotchiQuest',
		);

		return array_merge( $elements, $element );
	}
}
