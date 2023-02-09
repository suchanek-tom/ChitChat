import React from 'react';
import { Route, Switch } from 'react-router-dom';

import Left from './Left/Left';
import Right from './Right/Right';
import Blank from './Right/Blank';


class App extends React.Component{

render(){
    return(
        <div className='container py-5 px-3'>
            <div className='grid grid-rows-2 grid-flow-col'>
                <Left />
                <Switch>
                   <Route path="/" component={ Blank } exact/>
                    <Route path={'/conversation/:conversationid'} render={
                        props => <Right {...props} key={props.match.params.id} />
                    }/>
                </Switch>
            </div>
        </div>
    )
}
}

export default App;