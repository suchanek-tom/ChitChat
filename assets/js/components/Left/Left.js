import React from "react";

class Left extends React.Component{

    render(){
        return(
            <div className=" w-1/3 h-screen">
                <div className=" bg-white h-full border-2">
                    <div className=" border-b-2 ">
                        <p className=" mb-0 py-1 text-center font-bold text-2xl">Recent messages</p>
                    </div>
                    <div className="">

                    </div>
                </div>
            </div>
        );
    }
}

export default Left;