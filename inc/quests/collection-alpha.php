<?php

namespace Wapuugotchi\Wapuugotchi;

if (!defined('ABSPATH')) : exit(); endif; // No direct access allowed.

class Alpha
{

	public function __construct()
	{
		add_filter('wapuugotchi_quest_filter', array($this, 'add_wapuugotchi_filter'));
		//add_filter('admin_init', array($this, 'add_wapuugotchi_filter'));

	}

	public function add_wapuugotchi_filter($quests)
	{
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest('count_posts_1', null, 'Create 3 posts', 'You created 3 posts!!', 100, 20, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::firstPostCompleted'),
			new \Wapuugotchi\Wapuugotchi\Quest('count_posts_2', 'count_posts_1', 'Create 5 posts', 'You created 5 posts!!', 100, 25, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::secondPostCompleted'),
			new \Wapuugotchi\Wapuugotchi\Quest('count_posts_3', 'count_posts_2', 'Create 7 posts', 'You created 7 posts!!', 100, 30, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::thirdPostCompleted'),
			new \Wapuugotchi\Wapuugotchi\Quest('count_pages_1', null, 'Create 3 pages', 'You created 3 pages!!', 100, 20, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::firstPageCompleted'),
			new \Wapuugotchi\Wapuugotchi\Quest('count_pages_2', 'count_pages_1', 'Create 5 pages', 'You created 5 pages!!', 100, 25, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::secondPageCompleted'),
			new \Wapuugotchi\Wapuugotchi\Quest('count_pages_3', 'count_pages_3', 'Create 7 pages', 'You created 7 pages!!', 100, 30, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::thirdPageCompleted'),
			new \Wapuugotchi\Wapuugotchi\Quest('count_comment_1', null, 'Get your first comment', 'Nice, you got your first comment!', 100, 20, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::getCommentsCompleted_1'),
			new \Wapuugotchi\Wapuugotchi\Quest('count_comment_2', 'count_comment_1', 'Get 5 comments', 'Amazing, you got 5 comments!', 100, 25, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::getCommentsCompleted_2'),
			new \Wapuugotchi\Wapuugotchi\Quest('count_comment_3', 'count_comment_2', 'Get 10 comments', 'Awesome, you got 10 comments!!', 100, 30, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::getCommentsCompleted_3'),
			new \Wapuugotchi\Wapuugotchi\Quest('cleanup_themes_1', null, 'Remove all unused themes', 'nice, you now only have the active theme in your wordpress!', 100, 15, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::cleanupThemesCompleted_1'),
			new \Wapuugotchi\Wapuugotchi\Quest('use_seo_plugin_1', null, 'Activate a SEO plugin', 'You are using a SEO plugin. This helps a lot with the search engine optimization.', 100, 15, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::seoInstalledCompleted_1'),
			new \Wapuugotchi\Wapuugotchi\Quest('use_caching_plugin_1', null, 'Activate a caching plugin', 'You are using a caching plugin. So you can increase your performance.', 100, 15, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::cachingInstalledCompleted_1'),
			new \Wapuugotchi\Wapuugotchi\Quest('use_security_plugin_1', null, 'Activate a security plugin', 'You are using a security plugin. So you can increase your performance.', 100, 15, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::securityInstalledCompleted_1'),
			new \Wapuugotchi\Wapuugotchi\Quest('login_1', null, 'Log in on 10 different days', 'Nice, you logged in for 10 consecutive days!', 100, 25, 'Wapuugotchi\Wapuugotchi\Alpha::alwaysTrue', 'Wapuugotchi\Wapuugotchi\Alpha::loginCompleted_1'),
		);

		return array_merge($default_quest, $quests);
	}

//Posts
	public static function alwaysTrue()
	{
		return true;
	}

	public static function firstPostCompleted()
	{
		return wp_count_posts()->publish >= 3;
	}

	public static function secondPostCompleted()
	{
		return wp_count_posts()->publish >= 5;
	}

	public static function thirdPostCompleted()
	{
		return wp_count_posts()->publish >= 7;
	}

	public static function firstPageCompleted()
	{
		return wp_count_posts('page')->publish >= 3;
	}

	public static function secondPageCompleted()
	{
		return wp_count_posts('page')->publish >= 5;
	}

	public static function thirdPageCompleted()
	{
		return wp_count_posts('page')->publish >= 7;
	}

	public static function cleanupThemesCompleted_1()
	{
		return (count(wp_get_themes()) === 1);
	}

	public static function seoInstalledCompleted_1()
	{
		$list = array('all-in-one-seo-pack', 'wordpress-seo', 'semrush-seo-writing-assistant', 'ahrefs-seo', 'seo-by-rank-math', 'wp-seopress');
		return self::is_active_plugin_in_list($list);
	}

	public static function cachingInstalledCompleted_1()
	{
		$list = array('wp-asset-clean-up', 'litespeed-cache', 'w3-total-cache', 'wp-optimize', 'wp-fastest-cache', 'wp-super-cache');
		return self::is_active_plugin_in_list($list);
	}

	public static function securityInstalledCompleted_1()
	{
		$list = array('all-in-one-wp-security-and-firewall', 'defender-security', 'better-wp-security', 'jetpack', 'really-simple-ssl', 'wp-simple-firewall', 'sucuri-scanner', 'wordfence');
		return self::is_active_plugin_in_list($list);
	}

	public static function getCommentsCompleted_1()
	{
		return (wp_count_comments()->approved >= 1);
	}

	public static function getCommentsCompleted_2()
	{
		return (wp_count_comments()->approved >= 5);
	}

	public static function getCommentsCompleted_3()
	{
		return (wp_count_comments()->approved >= 10);
	}

	public static function loginCompleted_1()
	{
		$quest_meta = self::count_days();
		if ($quest_meta['login_1']['days'] >= 10) {
			return true;
		}

		return false;
	}


	private static function count_days()
	{
		$quest_meta = get_user_meta(get_current_user_id(), 'wapuugotchi_quest_meta', true);
		if (!is_array($quest_meta) ||
			!isset($quest_meta['day_count']) ||
			!isset($quest_meta['day_count']['days']) ||
			!isset($quest_meta['day_count']['tstamp'])
		) {
			$quest_meta['day_count']['tstamp'] = 0;
			$quest_meta['day_count']['days'] = 0;
		}

		if ($quest_meta['day_count']['tstamp'] < strtotime('now')) {
			$quest_meta['day_count']['tstamp'] = strtotime('tomorrow noon');
			$quest_meta['day_count']['days'] += 1;
			update_user_meta(
				get_current_user_id(),
				'wapuugotchi_quest_meta',
				$quest_meta
			);
		}

		return $quest_meta;
	}


	//helper
	private static function is_active_plugin_in_list($list)
	{
		if (!is_array($list)) {
			return false;
		}
		$activated_plugin = get_option('active_plugins');
		$plugins = get_plugins();

		$activated_plugin_slugs = array();
		foreach ($activated_plugin as $p) {
			if (isset($plugins[$p])) {
				$activated_plugin_slugs[] = dirname($p);
			}
		}

		return !empty(array_intersect($list, $activated_plugin_slugs));
	}
}
