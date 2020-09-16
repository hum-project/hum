// Your actions and action constants here

// Action constants can be defined like this:
// export const AN_ACTION = "AN_ACTION";
export const ANSWERING = "ANSWERING"

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
})