import {GET_CONVERSATIONS, GET_MESSAGES} from "../constants/actionTypes";

export  const setConversations = (data) => {
    return{
        type: GET_CONVERSATIONS,
        items: data
    }
}

export  const setMessages = (data, id) => {
    return{
        type: GET_MESSAGES,
        message: data,
        conversationId: id
    }
}

export const fetchConversations = () => dispatch => {
    return fetch('/conversations/')
        .then(data => data.json())
        .then(data => {
           return dispatch(setConversations(data));
        });
}

export const fetchMessages = (id) => dispatch => {
    return fetch('/messages/${id}')
        .then(data => data.json())
        .then(data => {
            return dispatch(setMessages(data, id));
        });
}