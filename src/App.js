import { useState } from "@wordpress/element";
import Shop from "./components/Shop";
import { STORE_NAME } from "./store";
import { useSelect } from '@wordpress/data'; 

function App() {
  const { wapuu, collections, categories } = useSelect( select => {
    return {
      collections: select(STORE_NAME).getState().collections,
      wapuu: select(STORE_NAME).getWapuu(),
      categories: select(STORE_NAME).getCategories(),
    };
  });

	const unlockedCollection = wpPluginParam.unlockedCollection;
	const lockedCollection = wpPluginParam.lockedCollection;
	const [, setWapuu] = useState(wpPluginParam.wapuu);

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
