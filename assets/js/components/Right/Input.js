import React from "react"
import { Connect } from "react-redux"
//import * as actionCreators from '../../actions/conversation'

const mapStateToProps = (state) => {
    return state;
}

class Input extends React.Component{

    constructor(){
        super();
        this.state = {
            content: ''
        };

        this.handleChange = this.handleChange.bind(this);
        this.sendMessage = this.sendMessage.bind(this);
    }

    //sendmessage
    sendMessage(event){
        event.preventDefault();
        this.props.addMessage(this.state.content, this.props.id).then(() => {
            this.setState({content: ''})
        });
    }

    handleChange(event){
        this.setState(
            {content: event.target.value}
        )
    }


    render(){
        return(
            <div>
                <form action="#" className=" bg-white p-2 w-screen">
                    <div>
                        <input type="text" placeholder="Write your message!" 
                        className=" w-full p-2 rounded bg-gray-200 text-gray-600 placeholder-gray-600 focus:outline-none"/>
                        <div className="">
                            <button type="submit" className="">
                                send 
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        );
    }
}
export default Input;