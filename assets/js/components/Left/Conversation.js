import React from 'react';
import { Link } from "react-router-dom";


class Conversation extends React.Component {
    render() {
        return (
            <Link to={'/conversation/' + this.props.conversation.conversation_id} className=''>
                   <img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user"
                         width="50" className=" float-left mx-3"/>
                    <div className=" ml-4">
                        <div className="flex align-items-center mb-1">
                            <h6 className="mb-0 text-lg">{this.props.conversation.username}</h6>
                            <p className=" ml-auto mr-2 font-bold">{new Date(this.props.conversation.createdAt).toLocaleDateString()}</p>
                        </div>
                        <p className="font-italic mb-0 text-small">{this.props.conversation.content}</p>
                    </div> 
            </Link>
        );
    }
}

export default Conversation;