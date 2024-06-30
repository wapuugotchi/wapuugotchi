<?php
/**
 * The QuizWordPress Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quiz\Data;

use Wapuugotchi\Quiz\Models\Quiz;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class AutoMessage
 */
class QuizWordPress {

	/**
	 * Initialization filter for QuestStart
	 *
	 * @param array $quiz The messages.
	 *
	 * @return array|Quest[]
	 */
	public static function add_wp_quiz( $quiz ) {
		$quiz[] = new Quiz(
			'wp_question_1',
			'Who is the founder of WordPress?',
			array('Chuck Norris', 'Bill Gates'),
			'Matt Mullenweg',
			'That\'s correct! Matt Mullenweg developed the first version of WordPress together with Mike Little in 2003. He is also the founder of Automattic.',
			'That is unfortunately incorrect. The correct answer is Matt Mullenweg.'
		);

		$quiz[] = new Quiz(
			'wp_question_2',
			'What is the name of the first default theme in WordPress?',
			array('Tinky Winky', 'Twenty Twenty'),
			'Twenty Ten',
			'That\'s correct! Twenty Ten was the first default theme in WordPress, released with WordPress 3.0 in 2010.',
			'That is unfortunately incorrect. The correct answer is Twenty Ten.'
		);

		$quiz[] = new Quiz(
			'wp_question_3',
			'What is the name of the mascot of WordPress?',
			array('Ronald McDonald', 'Mickey Mouse'),
			'Wapuu',
			'That\'s correct! Wapuu is the mascot of WordPress. It was designed by Kazuko Kaneuchi for the WordPress Japan community.',
			'That is unfortunately incorrect. The correct answer is Wapuu.'
		);

		$quiz[] = new Quiz(
			'wp_question_4',
			'What is the name of the first version of WordPress?',
			array('WordPress 1.0', 'WordPress 0.0.7'),
			'WordPress 0.7',
			'That\'s correct! The first version of WordPress was WordPress 0.7, released on May 27, 2003.',
			'That is unfortunately incorrect. The correct answer is WordPress 0.7.'
		);

		$quiz[] = new Quiz(
			'wp_question_5',
			'What is the name of the first plugin in WordPress?',
			array('Wapuugotchi', 'Akismet'),
			'Hello Dolly',
			'That\'s correct! Hello Dolly was the first plugin in WordPress, written by Matt Mullenweg.',
			'That is unfortunately incorrect. The correct answer is Hello Dolly.'
		);

		$quiz[] = new Quiz(
			'wp_question_6',
			'What is the name of the first WordCamp?',
			array('WordCamp Tokio', 'WordCamp Berlin'),
			'WordCamp San Francisco',
			'That\'s correct! WordCamp San Francisco was the first WordCamp, organized by Matt Mullenweg in 2006.',
			'That is unfortunately incorrect. The correct answer is WordCamp San Francisco.'
		);

		$quiz[] = new Quiz(
			'wp_question_7',
			'What programming language is WordPress built on?',
			array('Java', 'Python'),
			'PHP',
			'That\'s correct! WordPress is written in PHP.',
			'That is unfortunately incorrect. The correct answer is PHP.'
		);

		$quiz[] = new Quiz(
			'wp_question_8',
			'What file type is commonly used for themes and plugins in WordPress?',
			array('BRO', 'PNG'),
			'ZIP',
			'That\'s correct! Themes and plugins in WordPress are commonly distributed as ZIP files.',
			'That is unfortunately incorrect. The correct answer is ZIP.'
		);

		$quiz[] = new Quiz(
			'wp_question_9',
			'What is the name of the marketplace for WordPress plugins and themes?',
			array('Plugin Palace', 'Theme Forest'),
			'WordPress.org',
			'That\'s correct! WordPress.org is the marketplace for WordPress plugins and themes.',
			'That is unfortunately incorrect. The correct answer is WordPress.org.'
		);

		$quiz[] = new Quiz(
			'wp_question_10',
			'What is the maximum number of tags you can add to a WordPress post?',
			array('5', '10'),
			'Unlimited',
			'That\'s correct! You can add an unlimited number of tags to a WordPress post.',
			'That is unfortunately incorrect. The correct answer is Unlimited.'
		);

		$quiz[] = new Quiz(
			'wp_question_11',
			'What is the recommended permalink structure for SEO in WordPress?',
			array('Numeric', 'Day and name'),
			'Post name',
			'That\'s correct! The recommended permalink structure for SEO in WordPress is Post name.',
			'That is unfortunately incorrect. The correct answer is Post name.'
		);

		$quiz[] = new Quiz(
			'wp_question_12',
			'What does the acronym SEO stand for?',
			array('Super Easy Optimization', 'Space Exploration Organization', 'Secret Engine Operation'),
			'Search Engine Optimization',
			'That\'s correct! SEO stands for Search Engine Optimization and is the process of improving the visibility of a website in search engines.',
			'That is unfortunately incorrect. The correct answer is Search Engine Optimization.'
		);

		$quiz[] = new Quiz(
			'wp_question_13',
			'What is the term for additional functionality that can be added to WordPress?',
			array('Widget', 'Gizmo'),
			'Plugin',
			'That\'s correct! Plugins are additional pieces of software that can be added to WordPress to extend its functionality.',
			'That is unfortunately incorrect. The correct answer is Plugin.'
		);

		$quiz[] = new Quiz(
			'wp_question_14',
			'What is the main configuration file for a WordPress website?',
			array('config.sys', 'settings.ini'),
			'wp-config.php',
			'That\'s correct! wp-config.php is the main configuration file for a WordPress website.',
			'That is unfortunately incorrect. The correct answer is wp-config.php.'
		);

		$quiz[] = new Quiz(
			'wp_question_15',
			'Which protocol is used for securing a WordPress site?',
			array('HTTP', 'FTP'),
			'HTTPS',
			'That\'s correct! HTTPS is the protocol used for securing a WordPress site.',
			'That is unfortunately incorrect. The correct answer is HTTPS.'
		);

		$quiz[] = new Quiz(
			'wp_question_16',
			'What feature allows you to schedule posts in WordPress?',
			array('Future Post', 'Post Timer'),
			'Publish',
			'That\'s correct! The Publish feature in WordPress allows you to schedule posts to be published at a future date and time.',
			'That is unfortunately incorrect. The correct answer is Publish.'
		);

		$quiz[] = new Quiz(
			'wp_question_17',
			'Which role in WordPress has the highest level of access?',
			array('Editor', 'Author'),
			'Administrator',
			'That\'s correct! The Administrator role in WordPress has the highest level of access and can perform all tasks on the site.',
			'That is unfortunately incorrect. The correct answer is Administrator.'
		);

		$quiz[] = new Quiz(
			'wp_question_18',
			'What is a common security measure to protect a WordPress site?',
			array('Installing antivirus software', 'Disabling JavaScript'),
			'Using strong passwords',
			'That\'s correct! Using strong passwords is a common security measure to protect a WordPress site.',
			'That is unfortunately incorrect. The correct answer is Using strong passwords.'
		);

		$quiz[] = new Quiz(
			'wp_question_19',
			'How can you add custom functionality to a WordPress site without modifying the core files?',
			array('Editing the wp-admin folder', 'Modifying the index.php file'),
			'Using plugins',
			'That\'s correct! Using plugins is a way to add custom functionality to a WordPress site without modifying the core files.',
			'That is unfortunately incorrect. The correct answer is Using plugins.'
		);

		$quiz[] = new Quiz(
			'wp_question_20',
			'How can you improve the loading speed of a WordPress site?',
			array('Adding more plugins', 'Increasing the number of posts per page'),
			'Using a caching plugin',
			'That\'s correct! Using a caching plugin is a way to improve the loading speed of a WordPress site.',
			'That is unfortunately incorrect. The correct answer is Using a caching plugin.'
		);

		$quiz[] = new Quiz(
			'wp_question_21',
			'What is the name of the WordPress command line interface?',
			array('CommandPress', 'WP-Terminal'),
			'WP-CLI',
			'That\'s correct! WP-CLI is the command line interface for WordPress and allows you to manage your WordPress site from the command line.',
			'That is unfortunately incorrect. The correct answer is WP-CLI.'
		);

		$quiz[] = new Quiz(
			'wp_question_22',
			'Which of the following is a common issue when updating WordPress?',
			array('Faster website speed', 'Increased user registrations'),
			'Plugin compatibility problems',
			'That\'s correct! Plugin compatibility problems are a common issue when updating WordPress.',
			'That is unfortunately incorrect. The correct answer is Plugin compatibility problems.'
		);

		$quiz[] = new Quiz(
			'wp_question_23',
			'How do you access the WordPress admin dashboard?',
			array('By clicking a button on the homepage', 'By entering the secret code'),
			'By appending /wp-admin to the site URL',
			'That\'s correct! You can access the WordPress admin dashboard by appending /wp-admin to the site URL.',
			'That is unfortunately incorrect. The correct answer is By appending /wp-admin to the site URL.'
		);

		$quiz[] = new Quiz(
			'wp_question_24',
			'Why should you make a small donation for the Wapuugotchi plugin?',
			array('To make the plugin author rich', 'To increase your website traffic'),
			'To support the development and maintenance of the plugin',
			'Correct! With a small donation, you can support the further development of Wapuugotchi. There are many exciting plans ahead. Visit us at www.wapuugotchi.com!',
			'That is unfortunately incorrect. The correct answer is To support the development and maintenance of the plugin.'
		);

		return $quiz;
	}
}
