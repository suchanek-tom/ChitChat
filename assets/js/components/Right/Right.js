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

    componentDidUpdate(prevProps) {
        if (
            this.state._conversationIndex != -1
            && this.props.items[this.state._conversationIndex].messages?.length
            && prevProps.items[this.state._conversationIndex].messages?.length
        ) {
            this.scrollDown();
        }
    }

    //ScrollDown to the latest mess
    scrollDown() {
        this.bodyRef.current.scrollTop = this.bodyRef.current.scrollHeight;
    }

    //TODO: upravit
    componentDidMount(){
        const _conversationIndex = this.props.items.findIndex(
            conversation => {
            return conversation.conversationId == this.props.params.id;
        });
        this.setState({
            _conversationIndex: _conversationIndex
        });
        this.props.fetchMessages(this.props.match.params.id)
            .then(() => {
              this.scrollDown();
            });
    }

    componentWillUnmount() {
        if(this.state.eventSource instanceof EventSource){
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
                        this.state._conversationIndex != -1
                        && this.props.items != undefined
                        && this.props.items[this.state._conversationIndex].messages != undefined
                            ? this.props.items[this.state._conversationIndex]
                            .messages.map((message, index) => {
                                return (
                                    <Message message={messages} key={index} />
                                )
                            }) : ''
                    }
                </div>

                <Input id={this.props.match.params.id}/>
            </div>
        );
    }
}

export default connect(mapStateToProps, actionCreators)(Right);