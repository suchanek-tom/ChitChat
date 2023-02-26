import {
    GET_CONVERSATIONS,
    RECIEVE_CONVERSATIONS,
    GET_MESSAGES,
    RECIEVE_MESSAGES,
    ADD_MESSAGE,
    POST_MESSAGE,
    SET_HUBURL, SET_LAST_MESSAGE,
    SET_USERNAME
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
    conversation_id: id
});

export const receiveMessages = (json, id) => {
    return ({
        type: RECIEVE_MESSAGES,
        message: json,
        conversation_id: id
    });
};

export const postMessage = (json, id) => {
    return {
        type: ADD_MESSAGE,
        message: json,
        conversation_id: id
    }
};

export const setLastMessage = (message, conversation_id) => {
    return {
        type: SET_LAST_MESSAGE,
        message,
        conversation_id
    }
};

export const setHuburl = (url) => {
    return {
        type: SET_HUBURL,
        url
    };
};

export const setUsername = (username) => {
  return{
      type: SET_USERNAME,
      username
  }
};

export const fetchConversations = () => dispatch => {
    dispatch(requestConversations());
    return fetch(`/conversation/`)
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


export const addMessage = (content, conversation_id) => dispatch => {
    let formData = new FormData();
    formData.append('content', content);
    return fetch(`/message/${conversation_id}`, {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(json => {
            dispatch(setLastMessage(json, conversation_id))
            return dispatch(postMessage(json, conversation_id))
        })
};