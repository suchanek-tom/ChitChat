import {
    GET_CONVERSATIONS,
    RECIEVE_CONVERSATIONS,
    GET_MESSAGES,
    RECIEVE_MESSAGES,
    ADD_MESSAGE,
    POST_MESSAGE,
    SET_HUBURL,
    SET_EMAIL,
    SET_LAST_MESSAGE
} from "../constants/actionTypes";

export const requestConversations = () => ({
    type: GET_CONVERSATIONS,
});

export const receiveConversations = (json) => {
    return ({
        type: RECIEVE_CONVERSATIONS,
        items: json,
    })
};

export const requestMessages = (id) => ({
    type: GET_MESSAGES,
    conversationId: id
});

export const receiveMessages = (json, id) => {
    return ({
        type: RECIEVE_MESSAGES,
        messages: json,
        conversationId: id
    });
};

export const postMessage = (json, id) => {
    return {
        type: ADD_MESSAGE,
        message: json,
        conversationId: id
    }
};

export const setLastMessage = (message, conversationId) => {
    return {
        type: SET_LAST_MESSAGE,
        message,
        conversationId
    }
};

export const setHuburl = (url) => {
    return {
        type: SET_HUBURL,
        url
    };
};

export function setEmail(email) {
    return {
        type: SET_EMAIL,
        email
    };
}

export const fetchConversations = () => dispatch => {
    dispatch(requestConversations());
    return fetch(`/conversation`)
        .then(response => {

            const hubUrl = response.headers.get('Link').match(/<([^>]+)>;\s+rel=(?:mercure|"[^"]*mercure[^"]*")/)[1]
            dispatch(setHuburl(hubUrl));
            return response.json()
        })
        .then(json => {
            return dispatch(receiveConversations(json))
        })
};

export const fetchMessages = (id) => dispatch => {
    dispatch(requestMessages(id));
    return fetch(`/message/${id}`)
        .then(response => response.json())
        .then(json => {
            return dispatch(receiveMessages(json, id))
        })
};


export const addMessage = (content, conversationId) => dispatch => {
    let formData = new FormData();
    formData.append('content', content);
    return fetch(`/message/${conversationId}`, {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(json => {
            dispatch(setLastMessage(json, conversationId))
            return dispatch(postMessage(json, conversationId))
        })
};