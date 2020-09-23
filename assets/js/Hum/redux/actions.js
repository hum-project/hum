import axios from 'axios';

// Your actions and action constants here

// Action constants can be defined like this:
// export const AN_ACTION = "AN_ACTION";
export const ANSWERING = "ANSWERING";
export const RESOLVED_HUM = "RESOLVED_HUM";
export const REQUEST_HUM = "REQUEST_HUM";


// Actions should have a basic structure like this, optionally with some payload for "someData":
// export const basicAction = someData => ({
//     type: AN_ACTION,
//     payload: {
//         data: someData
//     }
// });

export const answerAction = (event, data) => ({
    type: ANSWERING,
    payload: {
        event: event,
        data: data
    }
});

export const getHum = () => {

    return function (dispatch) {
        dispatch(requestHum());
        return axios.get('https://localhost:8000/api/hums?page=1')
            .then(response => {
                console.log(response)
            })
            .then(dispatch(resolvedGetHum()));

    }
}

export const requestHum = () => {
    return {
        type: REQUEST_HUM
    }
}

export const resolvedGetHum = (json) => {
    return {
        type: RESOLVED_HUM,
        payload: {
            data: json
        }
    }
}