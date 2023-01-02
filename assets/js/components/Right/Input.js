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
            <div className=" border-t-2 py-3 px-3">
            <div className=" mx-auto my-auto w-full sm:w-full md:w-full">
                <form class="flex flex-row">    
                    <input
                        className="h-12 bg-gray-100 text-grey-darker text-grey-darkest border border-gray-100 w-full py-1 px-2 outline-none text-lg text-gray-600 rounded-l"
                        type="text" placeholder="Write your message..."/>
                    <span
                        className="flex items-center bg-gray-700 hover:opacity-80 duration-700 rounded rounded-l-none border-0 px-3 font-bold cursor-pointer">
                        <button
                            className="bg-gredient-dark hover:bg-gredient-light text-lg text-white font-bold py-2 px-6 rounded">Send</button>
                    </span>
                </form>
            </div>
        </div>
        );
    }
}
export default Input;