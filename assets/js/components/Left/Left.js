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

    componentDidMount() {
        //fetch conversations
        this.props.fetchConversations()
    }

    render(){
        return(
            <div className="h-screen  row-span-3">
                <div className=" bg-white h-full border-2 rounded-t">
                    <div className=" border-b-2 ">
                        <p className=" mb-0 py-1 text-center font-bold text-2xl">Recent messages</p>
                    </div>
                    <div className="">
                        <div className="list-group rounded">
                            {
                                this.props.children
                                    .sort((a, b) =>{
                                        return a.createdAt < b.createdAt;
                                    })
                                    .map((conversation, index) =>{
                                    return(
                                        <Conversation conversation={conversation} key={index}/>
                                    )
                                })
                            }
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default connect(mapStateToProps, actionCreators)(Left);