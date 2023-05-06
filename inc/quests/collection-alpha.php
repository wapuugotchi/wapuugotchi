<?php

namespace Wapuugotchi\Wapuugotchi;

if (!defined('ABSPATH')) : exit(); endif; // No direct access allowed.

class Posts
{

	public function __construct()
	{
		add_filter( 'wapuugotchi_quest_filter', array($this, 'add_wapuugotchi_filter') );
		//add_filter('admin_init', array($this, 'add_wapuugotchi_filter'));

	}

	public function add_wapuugotchi_filter($quests)
	{
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest('first_post', null, 'Create 3 posts', 'You created 3 posts!!', 100, 20, 'Wapuugotchi\Wapuugotchi\Posts::firstPostActive', 'Wapuugotchi\Wapuugotchi\Posts::firstPostCompleted'),
			new \Wapuugotchi\Wapuugotchi\Quest('second_post', 'first_post', 'Create 5 posts', 'You created 5 posts!!', 100, 25, 'Wapuugotchi\Wapuugotchi\Posts::secondPostActive', 'Wapuugotchi\Wapuugotchi\Posts::secondPostCompleted'),
			new \Wapuugotchi\Wapuugotchi\Quest('third_post', 'second_post', 'Create 7 posts', 'You created 7 posts!!', 100, 30, 'Wapuugotchi\Wapuugotchi\Posts::thirdPostActive', 'Wapuugotchi\Wapuugotchi\Posts::thirdPostCompleted'),
			new \Wapuugotchi\Wapuugotchi\Quest('mops', null, 'Drop your database', 'You created 7 posts!!', 100, 10, 'Wapuugotchi\Wapuugotchi\Posts::thirdPostActive', 'Wapuugotchi\Wapuugotchi\Posts::thirdPostCompleted'),
			new \Wapuugotchi\Wapuugotchi\Quest('klops', null, 'Add 1000 user', 'You created 7 posts!!', 100, 20, 'Wapuugotchi\Wapuugotchi\Posts::thirdPostActive', 'Wapuugotchi\Wapuugotchi\Posts::thirdPostCompleted'),
			new \Wapuugotchi\Wapuugotchi\Quest('drops', null, 'Learn japanese', 'You created 7 posts!!', 100, 30, 'Wapuugotchi\Wapuugotchi\Posts::thirdPostActive', 'Wapuugotchi\Wapuugotchi\Posts::thirdPostCompleted'),
			new \Wapuugotchi\Wapuugotchi\Quest('fips', null, 'Watch a movie', 'You created 7 posts!!', 100, 25, 'Wapuugotchi\Wapuugotchi\Posts::thirdPostActive', 'Wapuugotchi\Wapuugotchi\Posts::thirdPostCompleted')
		);

		return array_merge($default_quest, $quests);
	}


	public static function firstPostActive()
	{
		return true;
	}

	public static function firstPostCompleted()
	{
		return wp_count_posts()->publish >= 3;
	}

	public static function secondPostActive()
	{
		return true;
	}

	public static function secondPostCompleted()
	{
		return wp_count_posts()->publish >= 5;
	}

	public static function thirdPostActive()
	{
		return true;
	}

	public static function thirdPostCompleted()
	{
		return wp_count_posts()->publish >= 7;
	}
}
