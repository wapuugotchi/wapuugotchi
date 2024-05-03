import './log.scss';
import LogActiveQuests from './log-active-quests';
import LogCompletedQuests from './log-completed-quests';
import { __ } from '@wordpress/i18n';

export default function Log() {
	return (
		<div className="wapuugotchi_log">
			<h1>{ __( 'Active Quests', 'wapuugotchi' ) }</h1>
			<LogActiveQuests />
			<h1>{ __( 'Completed Quests', 'wapuugotchi' ) }</h1>
			<LogCompletedQuests />
		</div>
	);
}
