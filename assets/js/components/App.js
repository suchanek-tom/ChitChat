import React from 'react';
import { Route, Routes} from 'react-router-dom';

import Left from './Left/Left';
import Right from './Right/Right';
import Blank from './Right/Blank';


class App extends React.Component{

render(){
    return (
        <div className='container py-5 px-3'>
            <div className='grid grid-rows-2 grid-flow-col'>
                <Left />
                <Routes>
                    <Route path="/" element={<Blank />} exact />
                    <Route path="/conversation/:id" 
                            render={props => <Right {...props} key={props.match.params.id}></Right>}
                    />
                </Routes>
            </div>
        </div>
        )
          
}
}

export default App;