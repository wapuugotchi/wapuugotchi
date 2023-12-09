import './guide.scss';
import GuideHeader from "./guide-header";
import GuideContent from "./guide-content";
import GuideFooter from "./guide-footer";
import {useState} from "@wordpress/element";
import {useSelect} from "@wordpress/data";
import {STORE_NAME} from "../../store/onboarding";


export default function Guide() {
	const { current } = useSelect( ( select ) => {
		return {
			current: select( STORE_NAME ).getCurrent(),
		};
	} );

	const handleClick = ( count ) => {
		if (count === "next" && index < ( current?.tabs.length - 1 ) ) {
			setIndex(index + 1)
		} else {
			console.log("next Element!!!!")
		}
	}

	const [ index, setIndex ] = useState( 0 );

	return (
		<>
			<div className="wapuugotchi_onboarding__guide">
				<GuideHeader />
				<GuideContent current={ current?.tabs?.[ index ] } />
				<GuideFooter onHandleClick={handleClick}/>
			</div>
		</>
	);
}
