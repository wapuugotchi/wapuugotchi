import './log.scss';
import LogActiveQuests from './log-active-quests';
import LogCompletedQuests from './log-completed-quests';
import { __, sprintf } from '@wordpress/i18n';

export default function Log() {
	const activeQuests = Object.values(
		window.extWapuugotchiLogData?.active_quests ?? {}
	);
	const completedQuests = Object.values(
		window.extWapuugotchiLogData?.completed_quests ?? {}
	);
	const questCounts = sprintf(
		/* translators: 1: number of active quests, 2: number of completed quests. */
		__( '%1$d active · %2$d completed', 'wapuugotchi' ),
		activeQuests.length,
		completedQuests.length
	);

	return (
		<div className="wapuugotchi-quests wapuugotchi-quests__page">
			<div className="wapuugotchi-quests__header">
				<div className="wapuugotchi-quests__title">
					<h1>{ __( '🐾 WapuuGotchi – Quests', 'wapuugotchi' ) }</h1>
					<p className="subtitle">
						{ __(
							'Track your ongoing adventures and celebrate the ones you already finished.',
							'wapuugotchi'
						) }
					</p>
				</div>
				<div className="wapuugotchi-quests__pill">{ questCounts }</div>
			</div>

			<div className="wapuugotchi-quests__grid">
				<div className="wapuugotchi-quests__column">
					<h2>{ __( 'Active Quests', 'wapuugotchi' ) }</h2>
					<LogActiveQuests quests={ activeQuests } />
				</div>
				<div className="wapuugotchi-quests__column">
					<h2>{ __( 'Completed Quests', 'wapuugotchi' ) }</h2>
					<LogCompletedQuests quests={ completedQuests } />
				</div>
			</div>
		</div>
	);
}
