import React from 'react';
import { Route, Routes } from 'react-router-dom';

import Left from './Left/Left';
import Right from './Right/Right';
import Blank from './Right/Blank';

//app komponenta
class App extends React.Component{
render(){
    return (
        <div className=''>
            <div className='grid grid-rows-2 grid-flow-col'>
                <Left /> //Levý panel ostatních uživatelů
                //Routy = na kterého uživatelé kliknu tak se mi zobrazí vždy naše historie zpráv
                <Routes>
                    <Route path="/" element={<Blank />} exact /> //pravá část se zprávami
                    //část kde se nachází vstupní pole pro zadani textové zprávy
                    <Route path="/conversation/:id" element={<Right />}/>
                </Routes>
            </div>
        </div>
        );
    }
}

export default App;