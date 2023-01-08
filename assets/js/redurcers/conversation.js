import {GET_CONVERSATIONS} from "../constants/actionTypes";

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

        default:
            return state;
    }
}