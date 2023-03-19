import { useState } from "@wordpress/element";
import Shop from "./components/Shop";

function App() {
	const unlockedCollection = wpPluginParam.unlockedCollection;
	const lockedCollection = wpPluginParam.lockedCollection;
	const [wapuu, setWapuu] = useState(wpPluginParam.wapuu);

	const wapuuHandler = (newWapuu) => {
		setWapuu(newWapuu);
	};

	if (unlockedCollection.length !== 0) {
		return (
			<div>
				<Shop
					wapuu={wapuu}
					collection={unlockedCollection}
					lockedCollection={lockedCollection}
					onChangeWapuuConfig={wapuuHandler}
				/>
			</div>
		);
	}
}

export default App;
