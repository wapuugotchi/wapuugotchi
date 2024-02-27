<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Data;

use Wapuugotchi\Models\OnboardingItem;
use Wapuugotchi\Models\OnboardingPage;
use Wapuugotchi\Wapuugotchi\OnboardingTarget;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestContent
 */
class UpdateCoreData {

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
		$add_tour = array(
			new OnboardingPage(
				'update-core',
				'update-core.php',
				array(
					new OnboardingItem(
						__( 'Updates', 'wapuugotchi' ),
						__( 'We are now in the "Updates" section, which is also a part of the Dashboard. This section assists you in keeping your website up-to-date.', 'wapuugotchi' ),
						array(
							new OnboardingTarget(
								true,
								'#menu-dashboard .wp-submenu li a.current',
								'#menu-dashboard',
								0,
								'#FFCC00',
								null,
								0,
								false
							),
						)
					),
					new OnboardingItem(
						__( 'Explanation', 'wapuugotchi' ),
						__( 'Here, you can check whether updates are available for your website, including themes, plugins, and the WordPress core itself.', 'wapuugotchi' ),
						array(
							new OnboardingTarget(
								true,
								'#wpcontent',
								'#wpcontent',
								0,
								'#FFCC00',
								null,
								0,
								false
							),
						)
					),
					new OnboardingItem(
						__( 'Security Risk', 'wapuugotchi' ),
						__( 'It\'s crucial to keep your website updated at all times! Outdated software can compromise security. Updates provide not only security enhancements but also introduce new features.', 'wapuugotchi' ),
						array(
							new OnboardingTarget(
								true,
								'#wpcontent',
								'#wpcontent',
								0,
								'#FFCC00',
								null,
								0,
								false
							),
						)
					),
					new OnboardingItem(
						__( 'Conclusion', 'wapuugotchi' ),
						__( 'That concludes the "Dashboard" section, but our tour is far from over. I look forward to showing you much more. Let\'s move on quickly!', 'wapuugotchi' ),
						array(
							new OnboardingTarget(
								true,
								null,
								null,
								0,
								'#FFCC00',
								null,
								0,
								false
							),
						)
					),
				)
			),

		);

		return array_merge( $tour, $add_tour );
	}
}
