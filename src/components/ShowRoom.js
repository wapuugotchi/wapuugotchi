import React from "react";
import "./ShowRoom.css";

const ShowRoom = (props) => {
  const get_image_list = () => {
    let result = [];
    Object.keys(props.wapuu.char).map(category => {
      props.wapuu.char[category].key.map(WapuuItem => {
        props.collection[category].map(CollectionItem => {
          if (WapuuItem === CollectionItem.key) {
            result.push(CollectionItem);
          }
        })
      })
    })
    return result;
  }

  return (
    <div className="wapuu_show_room">
      {
        get_image_list().map(image => <img className="wapuu_show_room__image" key={image.key} src={image.path}/>)
      }
    </div>
  )
}
export default ShowRoom;
