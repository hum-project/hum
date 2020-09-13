import React, {Component} from "react";
import ThemeItem from "./ThemeItem";
import QuestionItem from "./QuestionItem";
import heartImage from'../../../images/Heart.png'
import VoteItem from "./VoteItem";

export default class Content extends Component {

    render() {
        const question2 = "87% of Swedes voted in the latest election, 2018. But not all voted on election day. Did you know that you can vote up to 18 days early?";
        const content = "General public health in Sweden is generally good. Different political parties sees different challenges however. Some parties sees how health in some groups are much better than in others. This has led to debate on how to improve health in the groups that are not as well off as others.";
        const nominals = ["Yes", "No"];
        const voteContent = "The representatives of the Parliament has voted to promote that each caretaker get's to have a say on the doctor they receive. The vote on a Regular Doctor Contact was also paired with two other propositions. A No-vote can mean that they oppose the other propositions. ";
        return (
            <div id="content">
                <div id="main-col">
                    <ThemeItem
                        heading={"Public Health"}
                        subheading={"Hum of the day"}
                        content={ content }
                        image={heartImage}
                    />
                    <QuestionItem
                        beeClass={"bottom right"}
                        questionType={"nominal"}
                        question={"Have you gotten the opportunity to choose a doctor when in contact with healthcare?"}
                        nominals={nominals}
                    />
                    <VoteItem
                        heading={"A Regular Designated Doctor"}
                        subheading={"Parliamentary Vote"}
                        content={ voteContent }
                        source={"https://riksdagen.se"}
                        vote={
                            {
                                yes: 233,
                                no: 54,
                                abstain: 11,
                                absent: 51
                            }
                        }
                    />
                    <QuestionItem
                        numOfCards={2}
                        beeClass={"top left"}
                        questionType={"nominal"}
                        question={question2}
                        nominals={nominals}
                    />
                </div>

                <div id="secondary-col">
                    <h2>Side content</h2>
                </div>
            </div>
        );
    }

}