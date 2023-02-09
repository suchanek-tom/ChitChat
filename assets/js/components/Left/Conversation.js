import React from 'react';
import {Link, NavLink} from "react-router-dom";


class Conversation extends React.Component {
    render() {
        return (
                <NavLink to={"/conversation" + this.props.Conversation.conversationId} className=" border py-3 hover:bg-slate-200 cursor-pointer">
                    <img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user"
                         width="50" className=" float-left mx-3"/>
                    <div className=" ml-4">
                        <div className="flex align-items-center mb-1">
                            <h6 className="mb-0 text-lg">{this.props.conversation.email}</h6>
                            <p className=" ml-auto mr-2 font-bold">{new Date(this.props.conversation.createdAt).toLocaleDateString()}</p>
                        </div>
                        <p className="font-italic mb-0 text-small">{}</p>
                    </div>
                </NavLink>

        );
    }
}

export default Conversation;