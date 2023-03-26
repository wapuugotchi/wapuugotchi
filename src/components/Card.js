import { useState } from '@wordpress/element';
import Categories from './Categories';
import './Card.css'
import { STORE_NAME } from "../store";
import { useSelect } from '@wordpress/data'; 

const Card = (props) => {
  const [selectedCategory, setSelectedCategory] = useState('fur')
  const { items, categories, wapuu } = useSelect( select => {
      return {
        wapuu: select(STORE_NAME).getWapuu(),
        items: select(STORE_NAME).getItems(),
        categories: select(STORE_NAME).getCategories(),  
      }
  });

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

    if(items[selectedCategory] !== undefined) {
      Object.values(items[selectedCategory]).map(item => {
        let classes = 'wapuu_card__item';
        if (wapuu.char[selectedCategory].key.includes(item.meta.key)) {
          classes += ' selected';
        } else if(item.meta.price > 0) {
          classes = 'wapuu_card__item wapuu_card__locked';
        }
        itemList.push({...item, classes: classes, tooltip: undefined})
      })
    }

    return itemList;
  }

  return (
    <div className='wapuu_card postbox'>
      <div className='wapuu_card__categories'>
        {
          Object.keys(categories).map(index => <Categories slug={index} category={categories[index]} handleSelection={handleSelectedCategory} selectedCategory={selectedCategory} /> )
        }
      </div>
      <div className='wapuu_card__items'>
        {
          getItemList().map(configItem => {
            return (
              configItem.meta.key !== undefined ?
              <div onClick={handleItem} category={selectedCategory} key={configItem.meta.key} data-key={configItem.meta.key} className={configItem.classes}>
                <img onClick={handleItem} className='wapuu_card__item_img' src={configItem.preview}/>
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
