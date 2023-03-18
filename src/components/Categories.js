
import './Categories.css'

const Categories = (props) => {

  const handleNewWare = (event) => {
    event.preventDefault();
    document.querySelectorAll('.wapuu_card__category').forEach(category => {
      category.classList.remove('selected')
    });
    event.target.classList.add('selected')
    props.selectedCategory(event.target.getAttribute('category')
    )
  }

  return (
    props.category === undefined ? '' :
      <div onClick={handleNewWare} category={props.category} className={props.category === 'fur' ? 'wapuu_card__category selected' : 'wapuu_card__category'}>
        <img className='wapuu_category__image' src={"/wp-content/plugins/wapuugotchi/img/icons/" + props.category + ".svg"}/>
      </div>
  );
}

export default Categories;
