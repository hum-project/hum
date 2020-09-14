import {ANSWERING} from "./actions";

const initialState = {
    language: "english",
    nominals: ["Yes", "No"],
    translation: {
        yes: 'Yes',
        no: 'No',
        abstain: 'Abstain',
        absent: 'Absent',
        source: 'Source',
        policySubheading: 'Parliamentary Vote',
        institutionSubheading: 'Institution in focus',
        humSubheading: 'Hum of the day',
        answersHeading: `You've answered 0 questions`,
        answersContent: 'Would you like to submit your answers to us?'
    },
    questions: [
        {
            id: 0,
            category: "nominal",
            content: "Have you gotten the opportunity to choose a doctor when in contact with healthcare?",
            answerOptions: {
                category: "nominal",
                values: ["Yes", "No"],
                isClicked: false
            },
            answer: null
        },
        {
            id: 1,
            category: "nominal",
            content: "87% of Swedes voted in the latest election, 2018. But not all voted on election day. Did you know that you can vote up to 18 days early?",
            answerOptions: {
                category: "nominal",
                values: ["Yes", "No"],
                isClicked: false
            },
            answer: null
        },
        {
            id: 2,
            category: "nominal",
            content: "Have you ever been in contact with an agency under the umbrella of the Ministry of Health and Social Services?",
            answerOptions: {
                category: "nominal",
                values: ["Yes", "No"],
                isClicked: false
            },
            answer: null
        }
    ],
    numOfAnswers: 0,
    institution: {
        header: "Ministry of Health and Social Services",
        content: "A Ministry is the governments expert organisation on how a policy should be implemented. The Ministry of Health and Social Services keeps track of governmental authorities that provide health services and social services. This ministry is responsible for directing each agency on what they are supposed to do as well as proving the funds they need. Some agencies that are under the umbrella of this ministry is:\n" +
            "\n" +
            "- Public Health Agency \n" +
            "- Social Insurance Agency\n" +
            "- National Board of Health and Welfare"
    },
    vote: {
        yes: 233,
        no: 54,
        abstain: 11,
        absent: 51
    },
    policy: {
        title: "A Regular Designated Doctor",
        content: "The representatives of the Parliament has voted to promote that each caretaker gets to have a say on the doctor they receive. The vote on a Regular Doctor Contact was also paired with two other propositions. A No-vote can mean that they oppose the other propositions.",
        source: "https://riksdagen.se"
    }
};

function contentReducer(state = initialState, action) {
    let target;
    let questions;
    switch (action.type) {
        case ANSWERING:
            target = action.payload.event.target;
            questions = [...state.questions]
            questions = questions.map(question => {
                if (question.id === action.payload.data.questionId) {
                    return Object.assign({}, question, {
                        answerOptions: Object.assign({}, question.answerOptions, {
                            isClicked: true
                        }),
                        answer: action.payload.data.value
                    });
                }
                return ({...question});
            });

            return Object.assign({}, state, {
                questions: [...questions],
                numOfAnswers: state.numOfAnswers + 1
            })
        default:
            return state;
    }
}

export default contentReducer;