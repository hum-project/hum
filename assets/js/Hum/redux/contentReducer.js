import {ANSWERING, INVALID, UNINVALIDATE, UPDATE_CONTENT} from "./actions";

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
        answersHeading: `You've answered [] question`,
        answersContent: "Would you like to submit these answers to us? By the release of the next Hum we will also share how people generally has answered. You don't have to do anything if you don't want to share them.",
        answersButton: "I'm intrigued, share them!"

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
    invalidInput: [],
    numOfAnswers: 0,
    institution: {
        header: "Ministry of Health and' Social Services",
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
    },
    raw: []
};

function contentReducer(state = initialState, action) {
    let target;
    let questions;
    let numOfAnswers;
    let currentQuestion;
    let invalids
    switch (action.type) {
        case ANSWERING:
            numOfAnswers = state.numOfAnswers;
            target = action.payload.event.target;
            questions = [...state.questions]
            questions = questions.map(question => {
                if (question.id === action.payload.data.questionId) {
                    currentQuestion = question;
                    if (!currentQuestion.answerOptions.isClicked) {
                        numOfAnswers++;
                    }
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
                numOfAnswers: numOfAnswers
            })
        case INVALID:
            invalids = [...state.invalidInput];
            invalids.push(action.payload.componentId);
            return Object.assign({}, state, {
                invalidInput: invalids
            });
        case UNINVALIDATE:
            invalids = [...state.invalidInput];
            invalids = invalids.filter(idOfInvalid => idOfInvalid !== action.payload.componentId);
            return Object.assign({}, state, {
                invalidInput: invalids
            });
        case UPDATE_CONTENT:
            let updateData = {...action.payload.data};
            let humData = updateData['hydra:member'][0];
            let questionsData = humData['questions'].filter(question => question['language']['name'].toLowerCase() === state['language'].toLowerCase() );
            let transformedQuestions = questionsData.map(question => transformQuestionHydra(question));
            let institutionData = humData['institution'];
            console.log(humData);
            console.log(questionsData);

            return Object.assign({}, state, {
                questions: transformedQuestions,
                raw: humData
            });
        default:
            return state;
    }
}

function transformQuestionHydra(question) {
    let category = parseQuestionCategory(question);
    let values;
    switch (category) {
        case 'nominal':
            values = question['nominalAnswers'].map(answer => answer.value);
            break;
        case 'ordinal':
            if (question['ordinalAnswers'].length > 0) {
                values = [1, question['ordinalAnswers'][0]['scale']];
                console.log(values);
            } else {
                values = [1, 5];
            }
            break;
        case 'continuous':
            values = [question['continuousAnswers'][0]['minimum'], question['continuousAnswers'][0]['maximum']];
            break;
        default:
            values = ["0", "0"];
    }
    return {
        id: question['id'],
        category: category,
        content: question['text'],
        answerOptions: {
            category: category,
            values: values,
            isClicked: false
        },
        answer: null
    }
}

function parseQuestionCategory(question) {
    let category;
    if (question['continuousAnswers'].length > 0) {
        category = 'continuous';
    } else if (question['ordinalAnswers'].length > 0) {
        category = 'ordinal';
    } else {
        category = 'nominal';
    }
    return category;
}

export default contentReducer;