import {ANSWERING, INVALID, UNINVALIDATE, UPDATE_CONTENT} from "./actions";

const initialState = {
    imageFolder: "/uploads/images/",
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
    questions: [],
    invalidInput: [],
    numOfAnswers: 0,
    theme: {
        header: "",
        content: "",
        symbol: {
            src: "",
            alt: ""
        },
    },
    institution: {
        header: "",
        content: ""
    },
    vote: {
        yes: 0,
        no: 0,
        abstain: 0,
        absent: 0
    },
    policy: {
        title: "",
        content: "",
        source: ""
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
            let transformedQuestions = questionsData.map(question => transformQuestion(question));
            console.log(humData);

            return Object.assign({}, state, {
                questions: transformedQuestions,
                policy: transformPolicy(humData.policy),
                vote: transformVote(humData.policy.vote),
                institution: transformInstitution(humData.institution),
                theme: transformTheme(humData.policy.policyTheme),
                raw: humData
            });
        default:
            return state;
    }
}

function transformTheme(theme) {
    return {
        header: theme.title,
        content: theme.text,
        symbol: {
            src: theme.symbol.fileName,
            alt: theme.symbol.alt,
        }
    }
}

function transformInstitution(institution) {
    return {
        header: institution.name,
        content: institution.text
    }
}
function transformPolicy(policy) {
    return {
        title: policy.title,
        content: policy.text,
        source: policy.source
    }
}

function transformVote(vote) {
    return {
        yes: vote.yes,
        no: vote.no,
        abstain: vote.abstain,
        absent: vote.absent
    };
}

function transformQuestion(question) {
    let category = parseQuestionCategory(question);
    let values;
    switch (category) {
        case 'nominal':
            values = question['nominalAnswers'].map(answer => answer.value);
            break;
        case 'ordinal':
            if (question['ordinalAnswers'].length > 0) {
                values = [1, question['ordinalAnswers'][0]['scale']];
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