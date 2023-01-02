import React from 'react';
import {Route, Switch} from 'react-router-dom';

import Left from './Left/Left';
import Right from './Right/Right';
import Blank from './Right/Blank';



class App extends React.Component{

render(){
    return(
        <div className=''>
            <div className='grid grid-rows-2 grid-flow-col'>
                <Left />
                <Blank />
                <Right />
            </div>
           
        </div>
    )
}
}

export default App;