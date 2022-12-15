import React, {useState} from 'react';
import ShowRoom from "./components/ShowRoom";
import Shop from "./components/Shop";

function App() {
  const collection = wpPluginParam.collection;
  const [wapuu, setWapuu] = useState(wpPluginParam.wapuu);

  const wapuuHandler = (newWapuu) => {
    setWapuu(newWapuu)
  }

  if (collection.length !== 0) {
    return (
      <div>
        <Shop wapuu={wapuu} collection={collection} onChangeWapuuConfig={wapuuHandler}/>
        <ShowRoom wapuu={wapuu} collection={collection}/>
      </div>
    );
  }
}

export default App;
