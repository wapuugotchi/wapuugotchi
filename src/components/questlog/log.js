import './log.scss';
import { __ } from '@wordpress/i18n';
import {useState} from "@wordpress/element";
import Reward from "./reward";

export default function Log() {

	const [quests] = useState(Object.values(window.extWapuugotchiLogData?.quests).sort(sortQuests));
	const [selectedQuest, setSelectedQuest] = useState(0);

	function getQuest(index = selectedQuest) {
		console.log(quests.at(index).rewards);
		return quests.at(index)
	}

	function changeSelection(index) {
		let selected = getQuest(index)
		if (isCompleted(selected.id) || isActive(selected.id)) {
			setSelectedQuest(index)
		}
	}

	function getClass(id) {
		if (getQuest().id === id) {
			return "wapuugotchi_log_list_quest selected";
		}
		if (isCompleted(id)) {
			return "wapuugotchi_log_list_quest completed";
		}
		if (!isCompleted(id) && !isActive(id)) {
			return "wapuugotchi_log_list_quest hidden";
		}
		return "wapuugotchi_log_list_quest";
	}

	function isCompleted(id) {
		return Object.keys(window.extWapuugotchiLogData?.completed).includes(id);
	}

	function isActive(id) {
		return window.extWapuugotchiLogData?.active?.includes(id);
	}

	function sortQuests(a, b) {
		if(isCompleted(a.id) && !isCompleted(b.id)) {
			return 1;
		}
		if(!isCompleted(a.id) && isCompleted(b.id)) {
			return -1;
		}
		if(isActive(a.id) && !isActive(b.id)) {
			return -1;
		}
		if(!isActive(a.id) && isActive(b.id)) {
			return 1;
		}
		return 0;
	}

	return (
		<div className="wapuugotchi_log">
			<div className="wapuugotchi_log_pages">
				<div className="wapuugotchi_log_list">
					<h1>{__('Quest Log', 'wapuugotchi')}</h1>
					<ul>
						{
						quests.map( ( value, index ) => (
							<li onClick={ () => changeSelection(index) } key={index} className={getClass(value.id)}>
								{ (isActive(value.id) || isCompleted(value.id)) ? __(value.title, 'wapuugotchi') : __('???', 'wapuugotchi') }
							</li>
						))
						}
					</ul>
				</div>
				<span className="wapuugotchi_log_divider"></span>
				<div className="wapuugotchi_log_description">
					<h1 className="wapuugotchi_log_description_title">{__(getQuest().title, 'wapuugotchi')}</h1>
					<p className="wapuugotchi_log_description_text">{__(getQuest().description, 'wapuugotchi')}</p>
					<span className="wapuugotchi_log_description_divider"></span>
					<h2>{__('Rewards', 'wapuugotchi')}</h2>
					<div className="wapuugotchi_log_description_rewards">
						{
							Object.keys(getQuest().rewards).map( ( value, index ) => (
								<Reward key={value} type={value} amount={getQuest().rewards[value]} claimed={isCompleted(getQuest().id)} />
							))
						}
					</div>
				</div>
			</div>
		</div>
	);
}
