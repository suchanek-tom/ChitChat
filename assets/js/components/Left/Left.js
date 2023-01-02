import React from "react";

class Left extends React.Component{

    render(){
        return(
            <div className="h-screen  row-span-3">
                <div className=" bg-white h-full border-2 rounded-t">
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