<?php

namespace Wapuugotchi\Wapuugotchi;

if (!defined('ABSPATH')) :
	exit();
endif; // No direct access allowed.

class Quests
{

	public function __construct()
	{
		//add_filter('wapuugotchi_quest_filter', array($this, 'wapuugotchi_quest_filter'), 10, 1);
		add_action('admin_init', array($this, 'init'), 20, 0);
	}

	public function init()
	{
		if (empty(get_user_meta(get_current_user_id(), 'wapuugotchi_completed_quests', true))) {
			update_user_meta(
				get_current_user_id(),
				'wapuugotchi_completed_quests',
				array()
			);
		}

		$completed_quests = $this->check_quest_progress();
		$this->update_completed_quests($completed_quests);
		$this->add_pearls($completed_quests);
	}

	public static function get_all_quests()
	{
		$quest = wp_cache_get('wapuugotchi_quests');

		if (!empty($quest)) {
			return $quest;
		}

		$quest = apply_filters('wapuugotchi_quest_filter', array());


		wp_cache_set('wapuugotchi_quests', $quest);

		return $quest;
	}

	public static function get_active_quests()
	{
		$completed_quests = get_user_meta(get_current_user_id(), 'wapuugotchi_completed_quests', true);
		$all_quests = self::get_all_quests();
		$result_array = array();

		if (empty(wp_cache_get('wapuugotchi_quests')) || !is_array($completed_quests)) {
			return array();
		}
		foreach ($all_quests as $value) {
			if (in_array($value->getId(), array_keys($completed_quests))) {
				continue;
			}
			if (!$value->isActive()) {
				continue;
			}

			if ($value->getParentId() === null || in_array($value->getParentId(), array_keys($completed_quests))) {
				$result_array [] = $value;
			}
		}

		return $result_array;
	}

	public static function get_completed_quests()
	{
		return get_user_meta(get_current_user_id(), 'wapuugotchi_completed_quests', true);
	}

	private function check_quest_progress()
	{
		$active_quests = self::get_active_quests();
		$result = array();

		foreach ($active_quests as $quest) {
			if ($quest->isCompleted()) {
				$result[$quest->getId()] = $quest;
			}
		}

		return $result;
	}

	private function update_completed_quests($quests)
	{
		$completed_quests = get_user_meta(get_current_user_id(), 'wapuugotchi_completed_quests', true);
		$new_completed_quests = array();

		if ( !empty( $quests ) ) {
			$date = date("j F, Y \@ g:ia");
			foreach ($quests as $index => $quest) {
				$new_completed_quests[ $quest->getId() ] = array(
					'id' 	 => $quest->getId(),
					'title'	 => $quest->getTitle(),
					'date' 	 => $date,
					'pearls' => $quest->getPearls()
				);

			}
			update_user_meta(
				get_current_user_id(),
				'wapuugotchi_completed_quests',
				array_unique(array_merge($completed_quests, $new_completed_quests), SORT_REGULAR)
			);
		}
	}

	private function add_pearls($quests)
	{
		$pearls = 0;

		foreach ($quests as $quest) {
			$pearls += $quest->getPearls();
		}

		if ($pearls > 0) {
			$balance = json_decode(get_user_meta(get_current_user_id(), 'wapuugotchi_balance', true));
			$balance += $pearls;
			update_user_meta(get_current_user_id(), 'wapuugotchi_balance', $balance);
		}
	}
}
