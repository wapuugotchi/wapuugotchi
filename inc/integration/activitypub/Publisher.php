<?php
/**
 * Publisher for Wapuu ActivityPub activities.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Integration\ActivityPub;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Publisher
 *
 * Listens for wapuugotchi events and publishes ActivityPub activities.
 */
class Publisher {

	/**
	 * The custom post type for Wapuu activities.
	 */
	const POST_TYPE = 'wapuu_activity';

	/**
	 * Cooldown in seconds between activities per Wapuu.
	 */
	const COOLDOWN = 300; // 5 minutes.

	/**
	 * Milestone thresholds for pearl balance notifications.
	 *
	 * @var int[]
	 */
	const MILESTONES = array( 10, 25, 50, 100, 250, 500, 1000 );

	/**
	 * Initialize the publisher.
	 *
	 * @return void
	 */
	public static function init() {
		\add_action( 'init', array( self::class, 'register_post_type' ) );
		\add_action( 'wapuugotchi_quest_completed', array( self::class, 'on_quest_completed' ), 10, 2 );
		\add_action( 'wapuugotchi_avatar_updated', array( self::class, 'on_avatar_updated' ), 10, 1 );
		\add_action( 'wapuugotchi_mission_step_completed', array( self::class, 'on_mission_step_completed' ), 10, 1 );
		\add_action( 'wapuugotchi_balance_changed', array( self::class, 'on_balance_changed' ), 10, 2 );
	}

	/**
	 * Register the custom post type for Wapuu activities.
	 *
	 * @return void
	 */
	public static function register_post_type() {
		\register_post_type(
			self::POST_TYPE,
			array(
				'labels'       => array(
					'name'          => \__( 'Wapuu Activities', 'wapuugotchi' ),
					'singular_name' => \__( 'Wapuu Activity', 'wapuugotchi' ),
				),
				'public'       => false,
				'show_ui'      => false,
				'hierarchical' => false,
				'rewrite'      => false,
				'supports'     => array( 'title', 'editor', 'author' ),
			)
		);

		\add_post_type_support( self::POST_TYPE, 'activitypub' );
	}

	/**
	 * Handle quest completion.
	 *
	 * @param string $quest_id The quest ID.
	 * @param int    $user_id  The user ID.
	 *
	 * @return void
	 */
	public static function on_quest_completed( $quest_id, $user_id ) {
		if ( self::is_on_cooldown( $user_id ) ) {
			return;
		}

		$quest = \Wapuugotchi\Quest\Handler\QuestHandler::get_quest_by_id( $quest_id );
		if ( ! $quest ) {
			return;
		}

		$content = \sprintf(
			// translators: 1: quest title, 2: pearl reward.
			\__( "I just completed the quest '%1\$s' and earned %2\$d pearls! 🎉", 'wapuugotchi' ),
			$quest->get_title(),
			$quest->get_pearls()
		);

		self::create_activity( $content, $user_id );
	}

	/**
	 * Handle avatar update.
	 *
	 * @param int $user_id The user ID.
	 *
	 * @return void
	 */
	public static function on_avatar_updated( $user_id ) {
		if ( self::is_on_cooldown( $user_id ) ) {
			return;
		}

		$content = \__( 'I got a new look! ✨', 'wapuugotchi' );

		self::create_activity( $content, $user_id );
	}

	/**
	 * Handle mission step completion.
	 *
	 * @param int $user_id The user ID.
	 *
	 * @return void
	 */
	public static function on_mission_step_completed( $user_id ) {
		if ( self::is_on_cooldown( $user_id ) ) {
			return;
		}

		$mission_data = \get_user_meta( $user_id, 'wapuugotchi_mission', true );
		if ( empty( $mission_data ) || ! isset( $mission_data['id'], $mission_data['progress'] ) ) {
			return;
		}

		$mission = \Wapuugotchi\Mission\Handler\MissionHandler::get_mission_by_id( $mission_data['id'] );
		if ( ! $mission ) {
			return;
		}

		$total    = \count( $mission->markers );
		$progress = (int) $mission_data['progress'];

		// Only post when mission is fully completed.
		if ( $progress < $total ) {
			return;
		}

		$content = \sprintf(
			// translators: %s is the mission name.
			\__( 'I just completed an adventure in %s! 🗺️', 'wapuugotchi' ),
			$mission->name
		);

		self::create_activity( $content, $user_id );
	}

	/**
	 * Handle balance change — post at milestone thresholds.
	 *
	 * @param int $amount  The amount added.
	 * @param int $user_id The user ID.
	 *
	 * @return void
	 */
	public static function on_balance_changed( $amount, $user_id ) {
		if ( self::is_on_cooldown( $user_id ) ) {
			return;
		}

		$amount      = (int) $amount;
		$balance     = (int) \get_user_meta( $user_id, 'wapuugotchi_balance', true );
		$old_balance = $balance - $amount;

		foreach ( self::MILESTONES as $milestone ) {
			if ( $old_balance < $milestone && $balance >= $milestone ) {
				$content = \sprintf(
					// translators: %d is the milestone pearl count.
					\__( 'I just reached %d pearls! 💎', 'wapuugotchi' ),
					$milestone
				);

				self::create_activity( $content, $user_id );
				return;
			}
		}
	}

	/**
	 * Create an activity post for a Wapuu.
	 *
	 * @param string $content The activity content.
	 * @param int    $user_id The WordPress user ID.
	 *
	 * @return int|\WP_Error The post ID or error.
	 */
	private static function create_activity( $content, $user_id ) {
		$wapuu_id = Wapuu::user_id_to_wapuu_id( $user_id );

		$post_id = \wp_insert_post(
			array(
				'post_type'    => self::POST_TYPE,
				'post_status'  => 'publish',
				'post_title'   => \wp_trim_words( $content, 10 ),
				'post_content' => $content,
				'post_author'  => $user_id,
			)
		);

		if ( ! \is_wp_error( $post_id ) ) {
			\update_post_meta( $post_id, '_activitypub_activity_actor', $wapuu_id );
			self::set_cooldown( $user_id );
		}

		return $post_id;
	}

	/**
	 * Check if a user's Wapuu is on cooldown.
	 *
	 * @param int $user_id The user ID.
	 *
	 * @return bool True if on cooldown.
	 */
	private static function is_on_cooldown( $user_id ) {
		return false !== \get_transient( 'wapuugotchi_ap_cooldown_' . $user_id );
	}

	/**
	 * Set the cooldown for a user's Wapuu.
	 *
	 * @param int $user_id The user ID.
	 *
	 * @return void
	 */
	private static function set_cooldown( $user_id ) {
		\set_transient( 'wapuugotchi_ap_cooldown_' . $user_id, true, self::COOLDOWN );
	}
}
