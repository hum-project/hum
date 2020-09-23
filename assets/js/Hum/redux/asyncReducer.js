import {REQUEST_HUM, RESOLVED_HUM} from "./actions";

function asyncReducer(state = {isFetching: false}, action) {

    switch (action.type) {
        case REQUEST_HUM:
            console.log("Getting hum");
            return state;
        case RESOLVED_HUM:
            console.log("Successfully got hum");
            return state;
        default:
            return state;
    }
}

export default asyncReducer;