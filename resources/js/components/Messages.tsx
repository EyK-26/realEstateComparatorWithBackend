import React, { useContext, FunctionComponent } from "react";
import UserContext from "../myApp/context/UserContext";

const Messages: FunctionComponent = () => {
    const { state } = useContext(UserContext);

    return (
        <>
            {state.messages.length > 0 && (
                <ul className="messages">
                    {state.messages.map((el, idx) => (
                        <li key={idx}>{el}</li>
                    ))}
                </ul>
            )}
        </>
    );
};

export default Messages;
