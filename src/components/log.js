import "./log.scss";
import LogActiveQuests from "./log-active-quests";
import LogCompletedQuests from "./log-completed-quests";

export default function Log() {
	return (
		<div className="wapuugotchi_log">
			<LogActiveQuests />
			<LogCompletedQuests />
		</div>
	);
}
