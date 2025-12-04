import { __ } from '@wordpress/i18n';

export default function Header() {
	return (
		<div className="wapuugotchi-support__header">
			<div className="wapuugotchi-support__title">
				<h1>
					{ __(
						'🐾 WapuuGotchi – Support & Feedback',
						'wapuugotchi'
					) }
				</h1>
				<p className="subtitle">
					{ __(
						'We read every message – sometimes replies take a moment.',
						'wapuugotchi'
					) }
				</p>
			</div>
		</div>
	);
}
