import React from 'react';

import Left from './Left/Left';
import Right from './Right/Right';
import Blank from './Right/Blank';

class App extends React.Component{

render(){
    return(
        <div className=' flex'>
            <Left/>
            <Right/>
        </div>
    )
}
}

export default App;