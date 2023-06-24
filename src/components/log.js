import "./log.scss";
import LogActiveQuests from "./log-active-quests";
import LogCompletedQuests from "./log-completed-quests";

export default function Log() {
	return (
		<div className="wapuugotchi_log">
			<h1>Active Quests</h1>
			<LogActiveQuests />
			<h1>Completed Quests</h1>
			<LogCompletedQuests />
		</div>
	);
}
