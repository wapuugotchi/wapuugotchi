import React, {useState, useEffect } from 'react';
import './Shop.css'
import Card from "./Card";
import axios from "axios";

const Shop = (props) => {
  const [name, setName] = useState(props.wapuu.name)
  const [loader, setLoader] = useState('Save Wapuu');
  const url = wpPluginParam.apiUrl + '/v1/wapuu'

  const nameChangeHandler = (event) => {
    setName(event.target.value);
  }
  const handleUpdateWare = (newWapuu) => {
    props.onSubmitWapuuConfig(newWapuu)
  }
  const handleReset = () => {
    axios.get( url )
      .then( ( res ) => {
        res.data.name = name;
        handleUpdateWare(res.data);
      })
  }
  const submitHandler = (event) => {
    event.preventDefault();
    setLoader('Saving...');

    props.wapuu.name = name;
    axios.post(url, {
      wapuu: props.wapuu
    }, {
      headers: {
        'content-type': 'application/json',
        'X-WP-NONCE': wpPluginParam.nonce
      }
    }).then((res) => {
      setLoader('Save Settings');
    })
  }

  return (
    <div className='wapuu_shop'>
      <form onSubmit={submitHandler}>
        <input type='text' value={name} onChange={nameChangeHandler}/>
        <button className='button button-primary' type='submit'>{loader}</button>
        <button onClick={handleReset} className='button button-secondary' type='button'>Clear</button>
        <Card collection={props.collection} wapuu={props.wapuu} onUpdateWare={handleUpdateWare}/>
      </form>
    </div>
  );
}

export default Shop;