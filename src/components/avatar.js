import { STORE_NAME } from "../store";
import { useSelect } from "@wordpress/data";
import "./avatar.scss";
import "./animation.scss";

export default function Avatar() {
	const { svg } = useSelect(select => {
		return {
			svg: select(STORE_NAME).getSvg()
		};
	});

	return (
		<svg xmlns="http://www.w3.org/2000/svg" x="0" y="0" version="1.1" viewBox="140 100 700 765"
				 dangerouslySetInnerHTML={{ __html: svg }}></svg>
	);
}

