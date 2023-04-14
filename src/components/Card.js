import {useEffect, useState} from '@wordpress/element';
import Categories from './Categories';
import './Card.css'
import {STORE_NAME} from "../store";

import {useSelect, dispatch} from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';

const Card = (props) => {
	const [selectedCategory, setSelectedCategory] = useState('fur');
	const {items, categories, wapuu} = useSelect(select => {
		return {
			wapuu: select(STORE_NAME).getWapuu(),
			items: select(STORE_NAME).getItems(),
			categories: select(STORE_NAME).getCategories(),
		}
	});

	const handleItem = (event) => {
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
					tooltip = item.meta.price;
				}

				itemList.push({...item, classes: classes, tooltip: tooltip})
			})
		}

		// Sort ItemList to show locked items at the end
		itemList.sort((a, b) => {
			if (a.meta.price > b.meta.price) {
				return 1;
			}
			if (a.meta.price < b.meta.price) {
				return -1;
			}
			return 0;
		});

		return itemList;
	}

	return (
		<div className='wapuu_card'>
			<div className='wapuu_card__categories'>
				{
					Object.keys(categories).map(index => <Categories key={index} slug={index}
																	 category={categories[index]}
																	 handleSelection={setSelectedCategory}
																	 selectedCategory={selectedCategory}/>)
				}
			</div>
			<div className='wapuu_card__items'>
				{
					getItemList().map(item => {
						return (
							<div onClick={handleItem} category={selectedCategory} key={item.meta.key}
								 data-key={item.meta.key} className={item.classes}>
								<img className='wapuu_card__item_img' src={item.preview}/>
								{
									item.tooltip !== undefined ?
										<div className="wapuu_card__item_pricetag">
											<img alt="" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTciIGhlaWdodD0iMTIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgZmlsbD0ibm9uZSIgdmlld0JveD0iMCAwIDE3IDEyIj4KCTxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik04Ljg5NiA0LjI0YTMuODg4IDMuODg4IDAgMCAwLTMuODggMy44OEEzLjg4OCAzLjg4OCAwIDAgMCA4Ljg5NiAxMmEzLjg4OCAzLjg4OCAwIDAgMCAzLjg4LTMuODggMy44ODkgMy44ODkgMCAwIDAtMy44OC0zLjg4Wm0xLjg0NyA0LjQxYy0uMjkgMC0uNTMtLjI0LS41My0uNTNhMS4zMyAxLjMzIDAgMCAwLTEuMzE3LTEuMzE3LjUzMy41MzMgMCAwIDEtLjUzLS41M2MwLS4yOS4yNC0uNTMuNTMtLjUzYTIuNCAyLjQgMCAwIDEgMi4zOTQgMi4zOTRjMCAuMjczLS4yNC41MTMtLjU0Ny41MTNaTTYuMjQ3IDMuMTExYy4wODUuMjA1LjI5LjMyNS40OTYuMzI1YS44NTQuODU0IDAgMCAwIC4yMDUtLjAzNC41MzQuNTM0IDAgMCAwIC4yOS0uNzAxTDYuNzI1IDEuNDdhLjU0OC41NDggMCAwIDAtLjctLjI5LjUzNC41MzQgMCAwIDAtLjI5MS43bC41MTMgMS4yMzFabS0uOTU3LjYzM0wzLjkyMiAyLjM3NmEuNTM3LjUzNyAwIDAgMC0uNzUyIDAgLjUzNy41MzcgMCAwIDAgMCAuNzUybDEuMzY3IDEuMzY4YS41My41MyAwIDAgMCAuMzc3LjE1NC41My41MyAwIDAgMCAuMzc2LS4xNTQuNTM3LjUzNyAwIDAgMCAwLS43NTJaTTMuODg4IDUuNDdsLTEuMjMtLjUxM2EuNTM0LjUzNCAwIDAgMC0uNzAyLjI5LjUzNC41MzQgMCAwIDAgLjI5LjcwMmwxLjIzMi41MTJhLjQzMy40MzMgMCAwIDAgLjIwNS4wMzVjLjIwNSAwIC40MS0uMTIuNDk1LS4zMjUuMTAzLS4yNzQtLjAxNy0uNTk4LS4yOS0uNzAxWm0tLjEwMyAyLjY1YS41MzIuNTMyIDAgMCAwLS41My0uNTNIMS4zMDdjLS4yOSAwLS41My4yMzktLjUzLjUzIDAgLjI5LjI0LjUzLjUzLjUzaDEuOTQ4Yy4yOTEgMCAuNTMtLjI0LjUzLS41M1ptLS4zMDcgMS42NzUtMS4yMzEuNTEzYS41MzQuNTM0IDAgMCAwLS4yOS43Yy4wODUuMjA2LjI5LjMyNS40OTUuMzI1YS44NTIuODUyIDAgMCAwIC4yMDUtLjAzNGwxLjIzLS41MTNhLjUzNC41MzQgMCAwIDAgLjI5MS0uNy41MzMuNTMzIDAgMCAwLS43LS4yOTFabTEyLjA2OC40OTUtMS4yMy0uNTEyYS41MzQuNTM0IDAgMCAwLS43MDIuMjkuNTM0LjUzNCAwIDAgMCAuMjkxLjcwMWwxLjIzLjUxM2EuNDMyLjQzMiAwIDAgMCAuMjA2LjAzNGMuMjA1IDAgLjQxLS4xMi40OTUtLjMyNWEuNTQ4LjU0OCAwIDAgMC0uMjktLjdabS45NC0yLjdoLTEuOTQ4Yy0uMjkgMC0uNTMuMjQtLjUzLjUzIDAgLjI5LjI0LjUzLjUzLjUzaDEuOTMxYy4yOSAwIC41My0uMjQuNTMtLjUzYS41MDguNTA4IDAgMCAwLS41MTMtLjUzWm0tMi44NzItMS40MTlhLjU0LjU0IDAgMCAwIC40OTYuMzI1Ljg1NS44NTUgMCAwIDAgLjIwNS0uMDM0bDEuMjMxLS41MTNhLjUzNC41MzQgMCAwIDAgLjI5LS43MDEuNTQ4LjU0OCAwIDAgMC0uNy0uMjlsLTEuMjMxLjUxMmMtLjI3My4xMDMtLjM5My40MjctLjI5LjcwMVptMS4wMjYtMy43OTVhLjUzNy41MzcgMCAwIDAtLjc1MiAwTDEyLjUyIDMuNzQ0YS41MzcuNTM3IDAgMCAwIDAgLjc1Mi41My41MyAwIDAgMCAuMzc2LjE1NC41My41MyAwIDAgMCAuMzc2LS4xNTRsMS4zNjgtMS4zNjhhLjUzNy41MzcgMCAwIDAgMC0uNzUyWm0tMy43OTUgMS4wMjZhLjQzMy40MzMgMCAwIDAgLjIwNS4wMzQuNTQuNTQgMCAwIDAgLjQ5Ni0uMzI1bC41MTMtMS4yM2EuNTM0LjUzNCAwIDAgMC0uMjktLjcwMS41MzQuNTM0IDAgMCAwLS43MDIuMjlsLS41MTMgMS4yM2EuNTQ5LjU0OSAwIDAgMCAuMjkxLjcwMlptLTEuOTQ4LS4zOTNjLjI5IDAgLjUzLS4yNC41My0uNTNWLjUyOWMwLS4yOS0uMjQtLjUyOS0uNTMtLjUyOS0uMjkxIDAtLjUzLjI0LS41My41M3YxLjkzMmMwIC4zMDcuMjM5LjU0Ni41My41NDZaIi8+Cjwvc3ZnPgo=" />
											<span>{item.tooltip}</span>
										</div>
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
