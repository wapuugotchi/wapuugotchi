import { __ } from '@wordpress/i18n';
import './header.scss';

export default function Header( { progressLabel } ) {
	return (
		<div className="wapuugotchi_missions__header">
			<div className="wapuugotchi_missions__title">
				<h1>{ __( '🐾 WapuuGotchi – Missions', 'wapuugotchi' ) }</h1>
				<p className="subtitle">
					{ __(
						'Follow the current mission path, unlock checkpoints, and collect your pearls.',
						'wapuugotchi'
					) }
				</p>
			</div>
			{ progressLabel ? (
				<div className="wapuugotchi_missions__pill">
					{ progressLabel }
				</div>
			) : null }
		</div>
	);
}
