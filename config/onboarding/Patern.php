<?php

use Wapuugotchi\Models\OnboardingPage;
use Wapuugotchi\Wapuugotchi\OnboardingTarget;

function mops() {
	new OnboardingPage(
		'dashboard',
		'page',
		'freeze',
		array(
			new OnboardingItem(
				__( 'title', 'wapuugotchi' ), __( 'text', 'wapuugotchi' ),
				array(
					new OnboardingTarget( 'active', 'focus', 'overlay', 'delay', 'color', 'click', 'clickable', 'hover' ),
				)
			)
		)
	);
}
