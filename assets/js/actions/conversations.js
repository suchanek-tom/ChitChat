import {GET_CONVERSATIONS} from "../constants/actionTypes";

export  const setConversations = (data) => {
    return{
        type: GET_CONVERSATIONS,
        items: data
    }
}


export const fetchConversations = () => dispatch => {
    return fetch('/conversations/')
        .then(data => data.json())
        .then(data => {
           return dispatch(setConversations(data));
        });
}