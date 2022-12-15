import React, { useState } from 'react';
import Categories from './Categories';
import './Card.css'

const Card = (props) => {
  const [ware, setWare] = useState('fur')
  const categories = [ 'fur', 'cap', 'item', 'coat', 'pant', 'shoe', 'ball' ];

  const handleItem = (event) => {
    event.preventDefault();
    const data_key = event.target.getAttribute('data-key');

    Object.keys(props.collection).map( category => {
      if( props.collection[category] !== undefined ) {
      props.collection[category].map( item => {
        if( item.key === data_key) {
          let char = props.wapuu.char;
          let index = char[category].key.indexOf(data_key);
          if(index > -1) { // remove
            if(char[category].required === 1 && char[category].key.length === 1) {
              console.info('Required 1 item of this category')
            } else {
              char[category].key.splice(index, 1);
            }
          } else if ( char[category].key.length < props.wapuu.char[category].count ) { // add
            char[category].key.push(data_key)
          } else if(char[category].key.length === 1 && char[category].count === 1) { // replace
            char[category].key.splice(0, 1)
            char[category].key.push(data_key)
          }

          const wapuu = {
            ...props.wapuu,
            char: char
          }

          props.onUpdateWare(wapuu);
        }
      })}
    })
  }

  const handleSelectedCategory = (category) => {
    setWare(category)
  }

  return (
    <div className='wapuu_card postbox'>
      <div className='wapuu_card__categories'>
        {
          categories.map( category => <Categories ware={category} selectedCategory={handleSelectedCategory} />)
        }
      </div>
      <div className='wapuu_card__items'>
        {
          props.collection[ware] !== undefined ?
          props.collection[ware].map(configItem => {
            let classes = 'wapuu_card__item';
            if(props.wapuu.char[ware].key.includes(configItem.key)){
              classes+=' selected';
            }
            return (
            <div onClick={handleItem} ware={ware} key={configItem.key} data-key={configItem.key} className={classes}>
              <img onClick={handleItem} className='wapuu_card__item_img' src={configItem.prev} />
            </div>)}) : ''
        }
      </div>
    </div>
  );
}

export default Card;