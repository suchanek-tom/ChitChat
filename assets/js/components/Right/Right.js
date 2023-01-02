import React from "react";
import { Connect } from "react-redux";

import Input from "./Input";
import Message from "./Message";

const mapStateToProps = (state) => {
    return state;
};

class Right extends React.Component{
    
    constructor(props){
        super(props);
        this.bodyRef = React.createRef();
        this.state = {
            id: null,
            _conversationIndex: -1,
            eventSource: null
        }
    }

    //ScrollDown to the latest mess
    scrollDown() {
        this.bodyRef.current.scrollTop = this.bodyRef.current.scrollHeight;
    }

    componentDidUpdate(prevProps)
    {
        if(
            this.state._conversationIndex != -1
            && this.props.items[this.state._conversationIndex].messages?.lenght
            && prevProps.items[this.state._conversationIndex].messages?.lenght
        ){
            this.scrollDown();
        }
    }

    //TODO: componentDidMount()

    componentWillUnmount(){
        if (this.state.eventSource instanceof EventSource)
        {
            this.state.eventSource.close();
            this.setState({
                eventSource: null
            })
        }
    }

    render(){
        return(
            <div className="col-span-2">
                <div className=" px-4 py-5 bg-white" ref={this.bodyRef}>
                    {
                        //Message function
                    }
                </div>

                <Input />
            </div>
        );
    }
}

export default Right;