import {useEffect, useState} from '@wordpress/element';
import Categories from './Categories';
import './Card.css'
import {STORE_NAME} from "../store";

import {useSelect, dispatch} from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';

const Card = (props) => {
	const [selectedCategory, setSelectedCategory] = useState('fur')
	const {items, categories, wapuu} = useSelect(select => {
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

		const wapuu_data = wapuu;

		const data_key = event.target.getAttribute('data-key');
		const category = event.target.getAttribute('category');

		if( items[category] === undefined || items[category][data_key] === undefined ) {
			return;
		}

		let item_data = items[category][data_key];
		if(item_data.meta.price > 0){
			return;
		}

		const category_data = wapuu_data.char[category];
		if (category_data === undefined) {
			return;
		}

		if (category_data.key.includes(data_key)) {
			if (category_data.required > 0) {
				return;
			}
			let index = category_data.key.indexOf(data_key)
			category_data.key.splice(index, 1)
		} else {
			if (category_data.count < category_data.key.length + 1) {
				category_data.key.pop()
			}
			category_data.key.push(data_key)
		}

		dispatch(STORE_NAME).setWapuu(wapuu_data);

		document.querySelectorAll('.wapuu_card__item').forEach(item => {
			if (item.getAttribute('category') === category) {
				let key = item.getAttribute('data-key');
				if (category_data.key.includes(key)) {
					item.classList.add('selected')
				} else {
					item.classList.remove('selected')
				}
			}
		});
		/*
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
		*/
	}

	const getItemList = () => {
		let itemList = [];

		if (items[selectedCategory] !== undefined) {
			Object.values(items[selectedCategory]).map(item => {
				let classes = 'wapuu_card__item';
				if (wapuu.char[selectedCategory] !== undefined
					&& wapuu.char[selectedCategory].key.includes(item.meta.key)) {
					classes += ' selected';
				} else if (item.meta.price > 0) {
					classes = 'wapuu_card__item wapuu_card__locked';
				}

				let tooltip = undefined
				if (item.meta.price > 0) {
					tooltip = 'Price: ' + item.meta.price;
				}

				itemList.push({...item, classes: classes, tooltip: tooltip})
			})
		}

		return itemList;
	}

	return (
		<div className='wapuu_card postbox'>
			<div className='wapuu_card__categories'>
				{
					Object.keys(categories).map(index => <Categories key={index} slug={index}
																	 category={categories[index]}
																	 handleSelection={handleSelectedCategory}
																	 selectedCategory={selectedCategory}/>)
				}
			</div>
			<div className='wapuu_card__items'>
				{
					getItemList().map(item => {
						return (
							<div onClick={handleItem} category={selectedCategory} key={item.meta.key}
								 data-key={item.meta.key} className={item.classes}>
								<img onClick={handleItem} className='wapuu_card__item_img' src={item.preview}/>
								{
									item.tooltip !== undefined ?
										<div className="wapuu_card__item_pricetag"><span>{item.tooltip}</span></div>
										: ''
								}
							</div>
						)
					})
				}
			</div>
		</div>
	);
}

export default Card;
