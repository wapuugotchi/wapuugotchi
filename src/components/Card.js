import { useState } from '@wordpress/element';
import Categories from './Categories';
import './Card.css'

// window.getItemsByCategory = function(collections, category) {
//   debugger
//   let categories = Object.values(collections).map(_=>_.collections)
//     .reduce((acc, curr) => {
//       acc.push(...curr);
//       return acc;
//     }, []
//   );

//   categories = categories.filter(_ => _.caption === category);

//   categories = categories.map(_=> Object.values(_.items));

//   return [].concat(...categories);
// }

const Card = (props) => {
  const [selectedCategory, setSelectedCategory] = useState('fur')
  const categories = ['fur', 'cap', 'item', 'coat', 'pant', 'shoe', 'ball'];

  const handleSelectedCategory = (category) => {
    setSelectedCategory(category)
  }

  const handleItem = (event) => {
    event.preventDefault();
    const data_key = event.target.getAttribute('data-key');

    Object.keys(props.collection).map(category => {
      if (props.collection[category] !== undefined) {
        props.collection[category].map(item => {
          if (item.key === data_key) {
            let char = props.wapuu.char;
            let index = char[category].key.indexOf(data_key);
            if (index > -1) { // remove
              if (char[category].required === 1 && char[category].key.length === 1) {
                console.info('Required 1 item of this category')
              } else {
                char[category].key.splice(index, 1);
              }
            } else if (char[category].key.length < props.wapuu.char[category].count) { // add
              char[category].key.push(data_key)
            } else if (char[category].key.length === 1 && char[category].count === 1) { // replace
              char[category].key.splice(0, 1)
              char[category].key.push(data_key)
            }

            const wapuu = {
              ...props.wapuu,
              char: char
            }

            props.onChangeWapuuConfig(wapuu);
          }
        })
      }
    })
  }

  const getItemList = () => {
    let itemList = [];
    if(props.collection[selectedCategory] !== undefined) {
      props.collection[selectedCategory].map(configItem => {
        let classes = 'wapuu_card__item';
        if (props.wapuu.char[selectedCategory].key.includes(configItem.key)) {
          classes += ' selected';
        }
        itemList.push({"key": configItem.key, "classes": classes, "src": configItem.prev, "tooltip": undefined})
      });
    }
    if ( props.lockedCollection[selectedCategory] !== undefined ) {
      itemList.push({"key": undefined})
      props.lockedCollection[selectedCategory].map(configItem => {
        itemList.push({"key": configItem.key, "classes": 'wapuu_card__item wapuu_card__locked', "src": configItem.prev, "tooltip": configItem.tooltip})

      })
    }
    return itemList;
  }

  return (
    <div className='wapuu_card postbox'>
      <div className='wapuu_card__categories'>
        {
          categories.map(category => <Categories category={category} selectedCategory={handleSelectedCategory}/>)
        }
      </div>
      <div className='wapuu_card__items'>

        {
          getItemList().map(configItem => {
            return (
              configItem.key !== undefined ?
              <div onClick={handleItem} category={selectedCategory} key={configItem.key} data-key={configItem.key} className={configItem.classes}>
                <img onClick={handleItem} className='wapuu_card__item_img' src={configItem.src}/>
                {
                  configItem.tooltip !== undefined ?
                    <div className="wapuu_card__item_tooltiptext"><span>{configItem.tooltip}</span></div>
                    : ''
                }
              </div> : <hr/>
            )
          })
        }
      </div>
    </div>
  );
}

export default Card;
