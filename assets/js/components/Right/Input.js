import React from "react"
import {connect} from "react-redux";
import { SlPaperPlane } from "react-icons/sl"
import * as actionCreators from '../../actions/conversations'

const mapStateToProps = (state) => {
    return state;
}

class Input extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            content: ''
        }

        this.handleChange = this.handleChange.bind(this);
        this.sendMessage = this.sendMessage.bind(this);
    }

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
                <form action="#" class="flex flex-row">
                    <input
                        className="h-12 bg-gray-100 text-grey-darker text-grey-darkest border border-gray-100 w-full py-1 px-2 outline-none text-lg text-gray-600 rounded-l"
                        type="text"
                        placeholder="Write your message..."
                        onChange={this.handleChange}
                        value={this.state.content}
                    />
                    <span className="flex items-center bg-gray-700 hover:opacity-80 duration-700 rounded rounded-l-none border-0 px-3 font-bold cursor-pointer">
                        <button
                            type={"submit"}
                            onClick={this.sendMessage}
                            className="bg-dark hover:bg-light text-lg text-white font-bold py-2 px-6 rounded">
                            <SlPaperPlane className=" h-5"/>
                        </button>
                    </span>
                </form>
            </div>
        </div>
        );
    }
}
export default connect(mapStateToProps, actionCreators)(Input);