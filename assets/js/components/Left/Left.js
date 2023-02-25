import React from "react";
import Conversation from "./Conversation";
import {connect} from "react-redux";
import * as actionCreators from '../../actions/conversations';


const mapStateToProps = (state) => {
    return state;
}
class Left extends React.Component{

    constructor(props) {
        super(props);
    }

    UNSAFE_componentWillMount() {
        const _t = this;
        this.props.fetchConversations()
            .then(() => {
                eventSource.onmessage = function (event) {
                    debugger
                    const data = JSON.parse(event.data);
                    _t.props.setLastMessage(data, data.conversation.id);
                }
            });
    }


    render(){
        return(
            <div className="">
                <div className=" bg-white  border-2 rounded-t">
                    <div className=" border-b-2 ">
                        <p className=" mb-0 py-1 text-center font-bold text-2xl">Recent messages</p>
                    </div>
                    <div className="">
                        <div className="list-group rounded">
                           {
                                this.props.items != undefined ?
                                 
                                    this.props.items
                                    .sort((a, b) => {
                                        return a.createdAt < b.createdAt;
                                    })
                                    .map(conversation => {
                                        return(
                                            <Conversation conversation={conversation} key={index}/>
                                        )
                                    })
                                    : ''
                           }
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default connect(mapStateToProps, actionCreators)(Left);