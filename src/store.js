import { createReduxStore, register } from "@wordpress/data";

const STORE_NAME = 'wapuugotchi/wapuugotchi';

const DEFAULT_STATE = {  };

/**
 * - wp.data.select('wapuugotchi/wapuugotchi').getState() 
 *    
 *    returns the whole state data containing ALMOST ANYTHING 
 *    should be removed after finishing porting to react
 *    exists just for debugging purposes
 * 
 * - wp.data.select('wapuugotchi/wapuugotchi').getCollections()
 * 
 *    contains ALL items (both available(paid or price===0) and unavailable (=> not yet paid))
 * 
 * - wp.data.select('wapuugotchi/wapuugotchi').getCategories()
 * 
 *    returns an object representation (key=>category name, value=>category image url) of all categories
 */

/*
  import { useSelect } from "@wordpress/data";
  import { STORE_NAME } from './store.js'; 

  function YourComponent(props) {
    const { wapuu, collections, categories } = useSelect( select => {
      return {
        collections: select(STORE_NAME).getState().collections,
        wapuu: select(STORE_NAME).getWapuu(),
        categories: select(STORE_NAME).getCategories(),
      };
    });

    return <div>{foo}</div>;
  }
*/

/**
 * computes the available categories
 *
 * @param   {object} collections  @TODO: add description
 *
 * @return  {object} all (non empty) categories. key is category-name, value id category-image-url
 */
function _evalCategories(collections) {
  let categories = Object.values(collections).map(_=>_.collections)
    .reduce((acc, curr) => {
      acc.push(...curr);
      return acc;
    }, []
  );

  categories = categories.reduce((acc, curr) => { 
      if( !acc[curr.caption]) {
          // collect only categories with at least a single item
          if(!curr.items.length) { 
            acc[curr.caption]=curr.image;
          } 
      }
      return acc;
    }, 
    {}
  );

  return categories;
}

/**
 * computes filtered collections containing unlocked and locked items
 *
 * @param   {object} collections  @TODO: add description
 *
 * @return  {array} filtered items in same object shape as the raw collections structure   
 */
function _computeItems(collections) {
  const computedItems = {
    unlocked : {}, 
    locked : {},
  };

  for (const [hash, val] of Object.values(collections)) {
    computedItems.unlocked[hash] = {
      collections : [],
    };
    computedItems.locked[hash] = {
      collections : [],
    };

    for (const collection of val.collections) {
      computedItems.locked[hash].collections.push({
        caption : collection.caption,
        image : collection.image,
        items : Object.values(collection.items).filter(items => {
          // @TODO: filter locked items
        }),  
      });
    }

    // @TODO: same same for unlocked items
  }

  let categories = Object.values(collections).map(_=>_.collections)
    .reduce((acc, curr) => {
      acc.push(...curr);
      return acc;
    }, []
  );

  categories = categories.reduce((acc, curr) => { 
      if( !acc[curr.caption]) {
          // collect only categories with at least a single item
          if(!curr.items.length) { 
            acc[curr.caption]=curr.image;
          } 
      }
      return acc;
    }, 
    {}
  );

  return computedItems;
}

function create(initial_state = DEFAULT_STATE) {
  const store = createReduxStore(STORE_NAME, {
    /* 
      don't know if we need it right know
      but will be very useful if we need async actions
    */  
    // __experimentalUseThunks: true,
    reducer(state = {}, { type, payload }) {
      switch (type) {
        case "SET_COLLECTIONS": {
          return {
            ...state,
            collections: payload,
            categories : _evalCategories(payload),
            ..._computeItems(payload),
          };
        }
        case "SET_WAPUU": {
          return {
            ...state,
            wapuu : payload
          };
        }
      }

      return state;
    },
    actions : {
      setCollections(payload) {
        return {
          type: "SET_COLLECTIONS",
          payload,
        };
      },
      setWapuu(payload) {
        return {
          type: "SET_WAPUU",
          payload,
        };
      },  
    },
    selectors: {
      getState(state) {
        return state;
      },
      getCategories(state) {
        return state.categories;
      },
      getWapuu(state) {
        return state.wapuu;
      }
    },
    resolvers: {
      // getState() {
      //   debugger
      //   if(window['wapuugotchi/wapuugotchi-store-state-initial']===undefined) {
      //     throw new Error("Failed to access initial store data : window['wapuugotchi/wapuugotchi-store-state-initial'] is undefined !");
      //   }
      //   return {
      //     type: "SET_COLLECTIONS",
      //     payload: window['wapuugotchi/wapuugotchi-store-state-initial'],
      //   };
      // }      
    }
  });

  register(store);
}

// register the store now (lazy registration is not needed)
create();

/**
 * computes all items from given collections by category
 *
 * @param   {object}  collections  @TODO: 
 * @param   {string}  category     name of category 
 *
 * @return  {array}   array of items of this category
 */
function getItemsByCategory(collections, category) {
  let categories = Object.values(collections).map(_=>_.collections)
    .reduce((acc, curr) => {
      acc.push(...curr);
      return acc;
    }, []
  );

  categories = categories.filter(_ => _.caption === category);

  categories = categories.map(_=> Object.values(_.items));

  return [].concat(...categories);
}

export { STORE_NAME, getItemsByCategory };