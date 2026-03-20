<?php
/**
 * Wapuu Actor model for ActivityPub.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\ActivityPub;

use Activitypub\Activity\Actor;
use Activitypub\Collection\Actors;

use function Activitypub\get_rest_url_by_path;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Wapuu
 *
 * Represents a Wapuu as an ActivityPub actor.
 */
class Wapuu extends Actor {

	/**
	 * The offset used for Wapuu actor IDs.
	 *
	 * Wapuu actor ID = -1000000 - $user_id.
	 *
	 * @var int
	 */
	const ID_OFFSET = -1000000;

	/**
	 * The internal user ID (negative Wapuu ID).
	 *
	 * @var int
	 */
	protected $_id; // phpcs:ignore PSR2.Classes.PropertyDeclaration.Underscore

	/**
	 * The WordPress user ID of the Wapuu owner.
	 *
	 * @var int
	 */
	protected $wp_user_id;

	/**
	 * Constructor.
	 *
	 * @param int $wp_user_id The WordPress user ID of the Wapuu owner.
	 */
	public function __construct( $wp_user_id ) {
		$this->wp_user_id = $wp_user_id;
		$this->_id        = self::user_id_to_wapuu_id( $wp_user_id );
	}

	/**
	 * Convert a WordPress user ID to a Wapuu actor ID.
	 *
	 * @param int $user_id The WordPress user ID.
	 *
	 * @return int The Wapuu actor ID.
	 */
	public static function user_id_to_wapuu_id( $user_id ) {
		return self::ID_OFFSET - (int) $user_id;
	}

	/**
	 * Convert a Wapuu actor ID to a WordPress user ID.
	 *
	 * @param int $wapuu_id The Wapuu actor ID.
	 *
	 * @return int The WordPress user ID.
	 */
	public static function wapuu_id_to_user_id( $wapuu_id ) {
		return abs( (int) $wapuu_id + self::ID_OFFSET );
	}

	/**
	 * Check if a given ID is a Wapuu actor ID.
	 *
	 * @param int $id The ID to check.
	 *
	 * @return bool True if it is a Wapuu ID.
	 */
	public static function is_wapuu_id( $id ) {
		return is_numeric( $id ) && (int) $id < self::ID_OFFSET;
	}

	/**
	 * Get the actor type.
	 *
	 * @return string
	 */
	public function get_type() {
		return 'Service';
	}

	/**
	 * Whether the User manually approves followers.
	 *
	 * @return false
	 */
	public function get_manually_approves_followers() {
		return false;
	}

	/**
	 * Whether the User is discoverable.
	 *
	 * @return true
	 */
	public function get_discoverable() {
		return true;
	}

	/**
	 * Get the actor ID URL.
	 *
	 * @return string
	 */
	public function get_id() {
		$id = parent::get_id();

		if ( $id ) {
			return $id;
		}

		return get_rest_url_by_path( sprintf( 'actors/%d', $this->_id ) );
	}

	/**
	 * Get the preferred username.
	 *
	 * @return string
	 */
	public function get_preferred_username() {
		$user = \get_user_by( 'id', $this->wp_user_id );

		return 'wapuu-' . $user->user_login;
	}

	/**
	 * Get the display name.
	 *
	 * @return string
	 */
	public function get_name() {
		$user = \get_user_by( 'id', $this->wp_user_id );

		// translators: %s is the user's display name.
		return \sprintf( \__( "%s's Wapuu", 'wapuugotchi' ), $user->display_name );
	}

	/**
	 * Get the actor summary with stats.
	 *
	 * @return string
	 */
	public function get_summary() {
		$balance          = (int) \get_user_meta( $this->wp_user_id, 'wapuugotchi_balance', true );
		$completed_quests = \get_user_meta( $this->wp_user_id, 'wapuugotchi_quest_completed', true );
		$quest_count      = \is_array( $completed_quests ) ? \count( $completed_quests ) : 0;
		$mission_data     = \get_user_meta( $this->wp_user_id, 'wapuugotchi_mission', true );

		$parts = array();

		$parts[] = \sprintf(
			// translators: %d is the pearl count.
			\__( 'Pearls: %d', 'wapuugotchi' ),
			$balance
		);

		$parts[] = \sprintf(
			// translators: %d is the number of completed quests.
			\__( 'Quests completed: %d', 'wapuugotchi' ),
			$quest_count
		);

		if ( ! empty( $mission_data['id'] ) ) {
			$parts[] = \sprintf(
				// translators: %d is the mission progress.
				\__( 'Current mission progress: %d steps', 'wapuugotchi' ),
				(int) $mission_data['progress']
			);
		}

		return \wpautop( \implode( "\n", $parts ) );
	}

	/**
	 * Get the actor URL.
	 *
	 * @return string
	 */
	public function get_url() {
		$user = \get_user_by( 'id', $this->wp_user_id );

		return \home_url( '/@wapuu-' . $user->user_login );
	}

	/**
	 * Get the actor icon.
	 *
	 * @return array
	 */
	public function get_icon() {
		return array(
			'type' => 'Image',
			'url'  => AvatarEndpoint::get_avatar_url( $this->wp_user_id ),
		);
	}

	/**
	 * Get the inbox endpoint.
	 *
	 * @return string
	 */
	public function get_inbox() {
		return get_rest_url_by_path( sprintf( 'actors/%d/inbox', $this->_id ) );
	}

	/**
	 * Get the outbox endpoint.
	 *
	 * @return string
	 */
	public function get_outbox() {
		return get_rest_url_by_path( sprintf( 'actors/%d/outbox', $this->_id ) );
	}

	/**
	 * Get the followers endpoint.
	 *
	 * @return string
	 */
	public function get_followers() {
		return get_rest_url_by_path( sprintf( 'actors/%d/followers', $this->_id ) );
	}

	/**
	 * Get the following endpoint.
	 *
	 * @return string
	 */
	public function get_following() {
		return get_rest_url_by_path( sprintf( 'actors/%d/following', $this->_id ) );
	}

	/**
	 * Get the public key.
	 *
	 * @return array
	 */
	public function get_public_key() {
		return array(
			'id'           => $this->get_id() . '#main-key',
			'owner'        => $this->get_id(),
			'publicKeyPem' => Actors::get_public_key( $this->_id ),
		);
	}

	/**
	 * Get the published date.
	 *
	 * @return string
	 */
	public function get_published() {
		$user = \get_user_by( 'id', $this->wp_user_id );

		return \gmdate( 'Y-m-d\TH:i:s\Z', \strtotime( $user->user_registered ) );
	}

	/**
	 * Get the webfinger identifier.
	 *
	 * @return string
	 */
	public function get_webfinger() {
		return $this->get_preferred_username() . '@' . \wp_parse_url( \home_url(), \PHP_URL_HOST );
	}

	/**
	 * Get the endpoints.
	 *
	 * @return array
	 */
	public function get_endpoints() {
		return array(
			'sharedInbox' => get_rest_url_by_path( 'inbox' ),
		);
	}

	/**
	 * Get profile attachments (stats as PropertyValue fields).
	 *
	 * @return array
	 */
	public function get_attachment() {
		$attachments = array();

		$balance = (int) \get_user_meta( $this->wp_user_id, 'wapuugotchi_balance', true );
		$attachments[] = array(
			'type' => 'PropertyValue',
			'name' => \__( 'Pearls', 'wapuugotchi' ),
			'value' => (string) $balance,
		);

		$completed_quests = \get_user_meta( $this->wp_user_id, 'wapuugotchi_quest_completed', true );
		$quest_count      = \is_array( $completed_quests ) ? \count( $completed_quests ) : 0;
		$attachments[] = array(
			'type' => 'PropertyValue',
			'name' => \__( 'Quests Completed', 'wapuugotchi' ),
			'value' => (string) $quest_count,
		);

		$mission_data = \get_user_meta( $this->wp_user_id, 'wapuugotchi_mission', true );
		if ( ! empty( $mission_data['id'] ) ) {
			$attachments[] = array(
				'type' => 'PropertyValue',
				'name' => \__( 'Current Mission', 'wapuugotchi' ),
				'value' => $mission_data['id'],
			);
		}

		return $attachments;
	}

	/**
	 * Get the WordPress user ID of the Wapuu owner.
	 *
	 * @return int
	 */
	public function get_wp_user_id() {
		return $this->wp_user_id;
	}
}
