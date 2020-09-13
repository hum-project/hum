const initialState = {
    language: "english",
    nominals: ["Yes", "No"],
    voteCategories: {
        yes: 'Yes',
        no: 'No',
        abstain: 'Abstain',
        absent: 'Absent',
        source: 'Source'
    },
    questions: [
        {
            category: "nominal",
            content: "Have you gotten the opportunity to choose a doctor when in contact with healthcare?"
        },
        {
            category: "nominal",
            content: "87% of Swedes voted in the latest election, 2018. But not all voted on election day. Did you know that you can vote up to 18 days early?"
        },
        {
            category: "nominal",
            content: "Have you ever been in contact with an agency under the umbrella of the Ministry of Health and Social Services?"
        }
    ],
    institution: {
        header: "Ministry of Health and Social Services",
        content: "A Ministry is the governments expert organisation on how a policy should be implemented. The Ministry of Health and Social Services keeps track of governmental authorities that provide health services and social services. This ministry is responsible for directing each agency on what they are supposed to do as well as proving the funds they need. Some agencies that are under the umbrella of this ministry is:\n +\n" +
            "\n" +
            "- Public Health Agency \n" +
            "- Social Insurance Agency\n" +
            "- National Board of Health and Welfare"
    }
};

function contentReducer(state = initialState, action) {
    switch (action.type) {
        default:
            return state;
    }
}

export default contentReducer;