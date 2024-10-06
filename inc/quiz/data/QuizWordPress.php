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
			__( 'Who is the founder of WordPress?', 'wapuugotchi' ),
			array( __( 'Chuck Norris', 'wapuugotchi' ), __( 'Bill Gates', 'wapuugotchi' ), __( 'Harry Potter', 'wapuugotchi' ), __( 'Elon Musk', 'wapuugotchi' ), __( 'Albert Einstein', 'wapuugotchi' ) ),
			__( 'Matt Mullenweg', 'wapuugotchi' ),
			__( 'That\'s correct! Matt Mullenweg developed the first version of WordPress together with Mike Little in 2003. He is also the founder of Automattic.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Matt Mullenweg.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_2',
			__( 'What is the name of the first default theme in WordPress?', 'wapuugotchi' ),
			array( __( 'Tinky Winky', 'wapuugotchi' ), __( 'Twenty Twenty', 'wapuugotchi' ), __( 'Seven of Nine', 'wapuugotchi' ), __( 'C-3PO', 'wapuugotchi' ) ),
			__( 'Twenty Ten', 'wapuugotchi' ),
			__( 'That\'s correct! Twenty Ten was the first default theme in WordPress, released with WordPress 3.0 in 2010.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Twenty Ten.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_3',
			__( 'What is the name of the mascot of WordPress?', 'wapuugotchi' ),
			array( __( 'Ronald McDonald', 'wapuugotchi' ), __( 'Mickey Mouse', 'wapuugotchi' ), __( 'Sonic the Hedgehog', 'wapuugotchi' ), __( 'Optimus Prime', 'wapuugotchi' ) ),
			__( 'Wapuu', 'wapuugotchi' ),
			__( 'That\'s correct! Wapuu is the mascot of WordPress. It was designed by Kazuko Kaneuchi for the WordPress Japan community.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Wapuu.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_4',
			__( 'What is the name of the first version of WordPress?', 'wapuugotchi' ),
			array( __( 'WordPress 1.0', 'wapuugotchi' ), __( 'WordPress XP', 'wapuugotchi' ), __( 'WordPress Prologue', 'wapuugotchi' ), __( 'WordPress 2000', 'wapuugotchi' ), __( 'WordPress Zero', 'wapuugotchi' ) ),
			__( 'WordPress 0.7', 'wapuugotchi' ),
			__( 'That\'s correct! The first version of WordPress was WordPress 0.7, released on May 27, 2003.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is WordPress 0.7.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_5',
			__( 'What is the name of the first plugin in WordPress?', 'wapuugotchi' ),
			array( __( 'Wapuugotchi', 'wapuugotchi' ), __( 'Akismet', 'wapuugotchi' ), __( 'Yoast Zero', 'wapuugotchi' ), __( 'HackerDefender', 'wapuugotchi' ), __( 'Pluginator', 'wapuugotchi' ), __( 'SuperPlugin 1.0', 'wapuugotchi' ) ),
			__( 'Hello Dolly', 'wapuugotchi' ),
			__( 'That\'s correct! Hello Dolly was the first plugin in WordPress, written by Matt Mullenweg.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Hello Dolly.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_6',
			__( 'What is the name of the first WordCamp?', 'wapuugotchi' ),
			array( __( 'WordCamp Tokio', 'wapuugotchi' ), __( 'WordCamp Berlin', 'wapuugotchi' ), __( 'WordCamp Springfield', 'wapuugotchi' ), __( 'WordCamp Hogwarts', 'wapuugotchi' ), __( 'WordCamp Gondor', 'wapuugotchi' ), __( 'WordCamp Gotham', 'wapuugotchi' ) ),
			__( 'WordCamp San Francisco', 'wapuugotchi' ),
			__( 'That\'s correct! WordCamp San Francisco was the first WordCamp, organized by Matt Mullenweg in 2006.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is WordCamp San Francisco.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_7',
			__( 'What programming language is WordPress built on?', 'wapuugotchi' ),
			array( __( 'Java', 'wapuugotchi' ), __( 'Python', 'wapuugotchi' ), __( 'Klingon', 'wapuugotchi' ), __( 'C++', 'wapuugotchi' ), __( 'Morse Code', 'wapuugotchi' ), __( 'Ruby', 'wapuugotchi' ), __( 'Perl', 'wapuugotchi' ) ),
			__( 'PHP', 'wapuugotchi' ),
			__( 'That\'s correct! WordPress is written in PHP.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is PHP.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_8',
			__( 'What file type is commonly used for themes and plugins in WordPress?', 'wapuugotchi' ),
			array( __( 'BRO', 'wapuugotchi' ), __( 'PNG', 'wapuugotchi' ), __( 'MP3', 'wapuugotchi' ), __( 'EXE', 'wapuugotchi' ), __( 'DOC', 'wapuugotchi' ), __( 'TXT', 'wapuugotchi' ) ),
			__( 'ZIP', 'wapuugotchi' ),
			__( 'That\'s correct! Themes and plugins in WordPress are commonly distributed as ZIP files.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is ZIP.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_9',
			__( 'What is the name of the marketplace for WordPress plugins and themes?', 'wapuugotchi' ),
			array( __( 'Plugin Palace', 'wapuugotchi' ), __( 'Theme Forest', 'wapuugotchi' ) ),
			__( 'WordPress.org', 'wapuugotchi' ),
			__( 'That\'s correct! WordPress.org is the marketplace for WordPress plugins and themes.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is WordPress.org.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_10',
			__( 'What is the maximum number of tags you can add to a WordPress post?', 'wapuugotchi' ),
			array( __( '5', 'wapuugotchi' ), __( '10', 'wapuugotchi' ), __( '42', 'wapuugotchi' ), __( 'Pi', 'wapuugotchi' ) ),
			__( 'Unlimited', 'wapuugotchi' ),
			__( 'That\'s correct! You can add an unlimited number of tags to a WordPress post.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Unlimited.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_11',
			__( 'What is the recommended permalink structure for SEO in WordPress?', 'wapuugotchi' ),
			array( __( 'Numeric', 'wapuugotchi' ), __( 'Day and name', 'wapuugotchi' ), __( 'Custom', 'wapuugotchi' ), __( 'Random string of characters', 'wapuugotchi' ), __( 'Name and emoji', 'wapuugotchi' ), __( 'As many slashes as possible', 'wapuugotchi' ) ),
			__( 'Post name', 'wapuugotchi' ),
			__( 'That\'s correct! The recommended permalink structure for SEO in WordPress is Post name.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Post name.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_12',
			__( 'What does the acronym SEO stand for?', 'wapuugotchi' ),
			array( __( 'Super Easy Optimization', 'wapuugotchi' ), __( 'Space Exploration Organization', 'wapuugotchi' ), __( 'Search Everything Online', 'wapuugotchi' ), __( 'Sneaky Engagement Orchestrator', 'wapuugotchi' ), __( 'Success Every Opportunity', 'wapuugotchi' ) ),
			__( 'Search Engine Optimization', 'wapuugotchi' ),
			__( 'That\'s correct! SEO stands for Search Engine Optimization and is the process of improving the visibility of a website in search engines.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Search Engine Optimization.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_13',
			__( 'What is the term for additional functionality that can be added to WordPress?', 'wapuugotchi' ),
			array( __( 'Widget', 'wapuugotchi' ), __( 'Gizmo', 'wapuugotchi' ), __( 'Theme', 'wapuugotchi' ), __( 'Addon', 'wapuugotchi' ), __( 'Feature', 'wapuugotchi' ), __( 'Upgrade', 'wapuugotchi' ), __( 'Attachment', 'wapuugotchi' ) ),
			__( 'Plugin', 'wapuugotchi' ),
			__( 'That\'s correct! Plugins are additional pieces of software that can be added to WordPress to extend its functionality.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Plugin.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_14',
			__( 'What is the main configuration file for a WordPress website?', 'wapuugotchi' ),
			array( __( 'config.sys', 'wapuugotchi' ), __( 'settings.ini', 'wapuugotchi' ), __( 'admin.xml', 'wapuugotchi' ), __( 'setup.exe', 'wapuugotchi' ) ),
			__( 'wp-config.php', 'wapuugotchi' ),
			__( 'That\'s correct! wp-config.php is the main configuration file for a WordPress website.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is wp-config.php.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_15',
			__( 'Which protocol is used for securing a WordPress site?', 'wapuugotchi' ),
			array( __( 'HTTP', 'wapuugotchi' ), __( 'FTP', 'wapuugotchi' ), __( 'POP3', 'wapuugotchi' ), __( 'SMTP', 'wapuugotchi' ), __( 'SSH', 'wapuugotchi' ), __( 'SFTP', 'wapuugotchi' ) ),
			__( 'HTTPS', 'wapuugotchi' ),
			__( 'That\'s correct! HTTPS is the protocol used for securing a WordPress site.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is HTTPS.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_16',
			__( 'What feature allows you to schedule posts in WordPress?', 'wapuugotchi' ),
			array( __( 'Future Post', 'wapuugotchi' ), __( 'Post Timer', 'wapuugotchi' ), __( 'Time Machine', 'wapuugotchi' ), __( 'Post Scheduler', 'wapuugotchi' ), __( 'Post Planner', 'wapuugotchi' ) ),
			__( 'Publish', 'wapuugotchi' ),
			__( 'That\'s correct! The Publish feature in WordPress allows you to schedule posts to be published at a future date and time.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Publish.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_17',
			__( 'Which role in WordPress has the highest level of access?', 'wapuugotchi' ),
			array( __( 'Editor', 'wapuugotchi' ), __( 'Author', 'wapuugotchi' ), __( 'Contributor', 'wapuugotchi' ), __( 'Subscriber', 'wapuugotchi' ), __( 'Visitor', 'wapuugotchi' ), __( 'God', 'wapuugotchi' ) ),
			__( 'Administrator', 'wapuugotchi' ),
			__( 'That\'s correct! The Administrator role in WordPress has the highest level of access and can perform all tasks on the site.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Administrator.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_18',
			__( 'What is a common security measure to protect a WordPress site?', 'wapuugotchi' ),
			array( __( 'Installing antivirus software', 'wapuugotchi' ), __( 'Disabling JavaScript', 'wapuugotchi' ), __( 'Using weak passwords', 'wapuugotchi' ), __( 'Hiding the site from search engines', 'wapuugotchi' ) ),
			__( 'Using strong passwords', 'wapuugotchi' ),
			__( 'That\'s correct! Using strong passwords is a common security measure to protect a WordPress site.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Using strong passwords.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_19',
			__( 'How can you add custom functionality to a WordPress site without modifying the core files?', 'wapuugotchi' ),
			array( __( 'Editing the wp-admin folder', 'wapuugotchi' ), __( 'Modifying the index.php file', 'wapuugotchi' ), __( 'Using a magic wand', 'wapuugotchi' ), __( 'Writing a letter to WordPress', 'wapuugotchi' ) ),
			__( 'Using plugins', 'wapuugotchi' ),
			__( 'That\'s correct! Using plugins is a way to add custom functionality to a WordPress site without modifying the core files.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Using plugins.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_20',
			__( 'How can you improve the loading speed of a WordPress site?', 'wapuugotchi' ),
			array( __( 'Adding more plugins', 'wapuugotchi' ), __( 'Increasing the number of posts per page', 'wapuugotchi' ), __( 'Using a dial-up connection', 'wapuugotchi' ), __( 'Removing all WordPress files', 'wapuugotchi' ) ),
			__( 'Using a caching plugin', 'wapuugotchi' ),
			__( 'That\'s correct! Using a caching plugin is a way to improve the loading speed of a WordPress site.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Using a caching plugin.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_21',
			__( 'What is the name of the WordPress command line interface?', 'wapuugotchi' ),
			array( __( 'CommandPress', 'wapuugotchi' ), __( 'WP-Terminal', 'wapuugotchi' ), __( 'WP-Shell', 'wapuugotchi' ), __( 'WP-Commander', 'wapuugotchi' ) ),
			__( 'WP-CLI', 'wapuugotchi' ),
			__( 'That\'s correct! WP-CLI is the command line interface for WordPress and allows you to manage your WordPress site from the command line.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is WP-CLI.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_22',
			__( 'Which of the following is a common issue when updating WordPress?', 'wapuugotchi' ),
			array( __( 'Faster website speed', 'wapuugotchi' ), __( 'Increased user registrations', 'wapuugotchi' ) ),
			__( 'Plugin compatibility problems', 'wapuugotchi' ),
			__( 'That\'s correct! Plugin compatibility problems are a common issue when updating WordPress.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Plugin compatibility problems.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_23',
			__( 'How do you access the WordPress admin dashboard?', 'wapuugotchi' ),
			array( __( 'By clicking a button on the homepage', 'wapuugotchi' ), __( 'By entering the secret code', 'wapuugotchi' ), __( 'By appending /wp-admin to the site URL', 'wapuugotchi' ) ),
			__( 'By appending /wp-admin to the site URL', 'wapuugotchi' ),
			__( 'That\'s correct! You can access the WordPress admin dashboard by appending /wp-admin to the site URL.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is By appending /wp-admin to the site URL.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_24',
			__( 'Why should you make a small donation for the Wapuugotchi plugin?', 'wapuugotchi' ),
			array( __( 'To make the plugin author rich', 'wapuugotchi' ), __( 'To increase your website traffic', 'wapuugotchi' ), __( 'To make the Wapuu happy', 'wapuugotchi' ), __( 'To get a free t-shirt', 'wapuugotchi' ) ),
			__( 'To support the development of the plugin', 'wapuugotchi' ),
			__( 'Correct! With a small donation, you can support the further development of Wapuugotchi. There are many exciting plans ahead. Visit us at www.wapuugotchi.com!', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is To support the development and maintenance of the plugin.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_25',
			__( 'Which WordPress plugin is commonly used for search engine optimization (SEO)?', 'wapuugotchi' ),
			array( __( 'Akismet', 'wapuugotchi' ), __( 'Jetpack', 'wapuugotchi' ), __( 'WooCommerce', 'wapuugotchi' ), __( 'Contact Form 7', 'wapuugotchi' ) ),
			__( 'Yoast SEO', 'wapuugotchi' ),
			__( 'That\'s correct! Yoast SEO is one of the most popular plugins for search engine optimization in WordPress.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Yoast SEO.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_26',
			__( 'Which of the following is NOT a default post type in WordPress?', 'wapuugotchi' ),
			array( __( 'Post', 'wapuugotchi' ), __( 'Page', 'wapuugotchi' ), __( 'Attachment', 'wapuugotchi' ), __( 'Revision', 'wapuugotchi' ) ),
			__( 'Product', 'wapuugotchi' ),
			__( 'That\'s correct! Product is not a default post type in WordPress; it is usually added by plugins like WooCommerce.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Product.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_27',
			__( 'Which WordPress feature helps in managing multiple websites from a single installation?', 'wapuugotchi' ),
			array( __( 'Multiuser', 'wapuugotchi' ), __( 'Multilingual', 'wapuugotchi' ), __( 'Multi-domain', 'wapuugotchi' ), __( 'Multi-admin', 'wapuugotchi' ) ),
			__( 'Multisite', 'wapuugotchi' ),
			__( 'That\'s correct! The Multisite feature allows you to manage multiple WordPress sites from a single installation.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Multisite.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_29',
			__( 'Which plugin is typically used to build contact forms in WordPress?', 'wapuugotchi' ),
			array( __( 'WooCommerce', 'wapuugotchi' ), __( 'Yoast SEO', 'wapuugotchi' ), __( 'Jetpack', 'wapuugotchi' ), __( 'Akismet', 'wapuugotchi' ) ),
			__( 'Contact Form 7', 'wapuugotchi' ),
			__( 'That\'s correct! Contact Form 7 is a popular plugin for creating contact forms in WordPress.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Contact Form 7.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_30',
			__( 'Which plugin is typically used to add e-commerce functionality to a WordPress site?', 'wapuugotchi' ),
			array( __( 'WPForms', 'wapuugotchi' ), __( 'Smush', 'wapuugotchi' ), __( 'All in One SEO Pack', 'wapuugotchi' ), __( 'Disqus', 'wapuugotchi' ) ),
			__( 'WooCommerce', 'wapuugotchi' ),
			__( 'That\'s correct! WooCommerce is the most popular e-commerce plugin for WordPress, enabling online store functionality.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is WooCommerce.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_31',
			__( 'What are WordPress major versions named after?', 'wapuugotchi' ),
			array( __( 'Famous scientists', 'wapuugotchi' ), __( 'Space missions', 'wapuugotchi' ), __( 'Hollywood actors', 'wapuugotchi' ), __( 'Marvel characters', 'wapuugotchi' ) ),
			__( 'Jazz musicians', 'wapuugotchi' ),
			__( 'That\'s correct! Matt Mullenweg, the co-founder of WordPress, is a big jazz fan and wanted to bring a personal touch to the project.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Jazz musicians.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_32',
			__( 'When was the first WordCamp organized?', 'wapuugotchi' ),
			array( __( '2001', 'wapuugotchi' ), __( '2012', 'wapuugotchi' ), __( '🤔', 'wapuugotchi' ) ),
			__( '2006', 'wapuugotchi' ),
			__( 'That\'s correct! The first WordCamp was organized in 2006 by Matt Mullenweg in San Francisco.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is 2006.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_33',
			__( 'How many themes are currently hosted on WordPress.org?', 'wapuugotchi' ),
			array( __( 'Over 1,000', 'wapuugotchi' ), __( 'Over 5,000', 'wapuugotchi' ), __( 'Over 100', 'wapuugotchi' ), __( 'Over 2,500', 'wapuugotchi' ) ),
			__( 'Over 12,000', 'wapuugotchi' ),
			__( 'That\'s correct! There are currently over 12,000 themes hosted on WordPress.org.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Over 10,000.', 'wapuugotchi' )
		);

		$quiz[] = new Quiz(
			'wp_question_34',
			__( 'How many plugins are currently hosted on WordPress.org?', 'wapuugotchi' ),
			array( __( 'Over 10,000', 'wapuugotchi' ), __( 'Over 25,000', 'wapuugotchi' ), __( 'Over 40,000', 'wapuugotchi' ), __( 'Over 1,000', 'wapuugotchi' ), __( 'Over 5,000', 'wapuugotchi' ) ),
			__( 'Over 55,000', 'wapuugotchi' ),
			__( 'That\'s correct! There are currently over 55,000 plugins hosted on WordPress.org.', 'wapuugotchi' ),
			__( 'That is unfortunately incorrect. The correct answer is Over 60,000.', 'wapuugotchi' )
		);

		return $quiz;
	}
}
