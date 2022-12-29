import React from "react";

class Input extends React.Component{


    render(){
        return(
            <div>
                <form action="#" className=" bg-white p-2 w-screen">
                    <div>
                        <input type="text" placeholder="Write your message!" 
                        className=" w-full p-2 rounded bg-gray-200 text-gray-600 placeholder-gray-600 focus:outline-none"/>
                        <div className="">
                            <button type="submit" className="">
                                send 
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        );
    }
}
export default Input;