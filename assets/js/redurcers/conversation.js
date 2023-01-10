import {GET_CONVERSATIONS, GET_MESSAGES} from "../constants/actionTypes";
import conversation from "../components/Left/Conversation";

export default (
    state = {
        items: []
    },
        action
) => {
    switch (action.type){
        case GET_CONVERSATIONS:
            return {
                ...state,
                items: action.items
            }
        case GET_MESSAGES:
            const _newConversation = state.items.map(conversation => {
                return conversation.conversationId == action.conversationId
                    ? Object.assign({}, conversation, {messages: action.messages})
                    : conversation
                ;
            })
            return {
                ...state,
                items: _newConversation
            };
        default:
            return state;
    }
}