import React, { useState } from 'react';
import './Categories.css'

const Categories = (props) => {

  const handleNewWare = (event) => {
    event.preventDefault();
    document.querySelectorAll('.wapuu_card__category').forEach(category => {
      category.classList.remove('selected')
    });
    event.target.classList.add('selected')
    props.selectedCategory( event.target.getAttribute('ware')
  )
  }

  return (
    props.ware === undefined ? '' :
    <div onClick={handleNewWare} ware={props.ware} className={ props.ware === 'fur' ? 'wapuu_card__category selected' : 'wapuu_card__category' }>
      <img src={"/wp-content/plugins/wapuugotchi/img/icons/" + props.ware + ".svg"} />
    </div>
  );
}

export default Categories;