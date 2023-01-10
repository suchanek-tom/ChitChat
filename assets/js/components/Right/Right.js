import React from "react";
import {connect} from "react-redux";
import * as actionCreators from '../../actions/conversations'
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


    componentDidMount(){
        this.props.fetchMessages(this.props.match.params.id)
            .then(() => {
              this.scrollDown();
            });
    }

    componentWillUnmount() {

    }

    render(){
        const _conversationIndex = this.props.items.findIndex(conversation => {
            return conversation.conversationId == this.props.params.id;
        })
        return(
            <div className="col-span-2">
                <div className=" px-4 py-5 bg-white" ref={this.bodyRef}>
                    {
                        _conversationIndex != -1 ?
                        this.props.items[_conversationIndex].messages
                            ?.map(message, index => {
                                return (
                                    <Message message={messages} key={index} />
                                )
                            })
                            : ''
                    }
                </div>

                <Input />
            </div>
        );
    }
}

export default connect(mapStateToProps, actionCreators)(Right);