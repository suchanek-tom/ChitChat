import React from "react";
import { Connect } from "react-redux";

import Input from "./Input";

const mapStateToProps = (state) => {
    return state;
};

class Right extends React.Component{
    
    //ScrollDown
    scrollDown() {
        this.bodyRef.current.scrollTop = this.bodyRef.current.scrollHeight;
    }

    render(){
        return(
            <div className="w-screen">
                <div className=" bg-white">

                </div>
                <Input/>
            </div>
        );
    }
}

export default Right;