import React from 'react';
import { NavLink } from "react-router-dom";


class Conversation extends React.Component {
    render() {
        return (
                <div>
                      <img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user"
                         width="50" className=" float-left mx-3"/>
                    <div className=" ml-4">
                        <div className="flex align-items-center mb-1">
                            <h6 className="mb-0 text-lg">username</h6>
                            <p className=" ml-auto mr-2 font-bold">time</p>
                        </div>
                        <p className="font-italic mb-0 text-small">content</p>
                    </div> 
                </div>
        );
    }
}

export default Conversation;