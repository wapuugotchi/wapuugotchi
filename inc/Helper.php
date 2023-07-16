<?php

namespace Wapuugotchi\Wapuugotchi;

use DateTime;
use DateTimeZone;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

class Helper
{
	const COLLECTION_API_URL = 'https://api.wapuugotchi.com/collection';
	const COLLECTION_STRUCTURE = array(
		'fur'   => '',
		'balls' => '',
		'caps'  => '',
		'items' => '',
		'coats' => '',
		'shoes' => '',
	);
	static function getSecondsLeftUntilTomorrow() {
		$timezone = new DateTimeZone( wp_timezone_string() );

		$today = new DateTime('now', $timezone);
		$tomorrow = new DateTime('tomorrow', $timezone);

		return $tomorrow->getTimestamp() - $today->getTimestamp();
	}
}


