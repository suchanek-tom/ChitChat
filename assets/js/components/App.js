import React from 'react';
import {Route, Switch} from 'react-router-dom';

import Left from './Left/Left';
import Right from './Right/Right';
import Blank from './Right/Blank';



class App extends React.Component{

render(){
    return(
        <div className=' container py-5 px-4'>
            <div className=' row rounded-lg overflow-hidden shadow'>
                <Left/>
                
            </div>
           
        </div>
    )
}
}

export default App;