import React from "react";

class Message extends React.Component{

    render() {
        let img = '';
        if (!this.props.message.id){
            img = <img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user"
                       width="50" className="rounded-lg"/>
        }
        return(
            <div className={"w-10 mb-3 ${this.props.message.mine ? 'ml-auto' : ''}"} >
                {img}
                <div className="ml-3">
                    <div className="rounded py-2 px-3 mb-2 ${this.props.message.mine ? 'bg-slate-400' : 'bg-white'}">
                        <p className="text-xs mb-1 ${this.props.message.mine ? 'text-white' : 'text-black'}">{this.props.message.content}</p>
                    </div>
                    <p className="text-xs">{new Date(this.props.message.createdAt).toLocaleDateString()}</p>
                </div>
            </div>
        );
    }
}

export default Message;