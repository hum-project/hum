import React, {Component} from "react";
import {connect} from 'react-redux';


import QuestionItem from "./QuestionItem";
import heartImage from'../../../images/Heart.png'
import VoteItem from "./VoteItem";
import GenericItem from "./GenericItem";
import AnswersItem from "./AnswersItem";


class Content extends Component {

    render() {
        const content = "General public health in Sweden is generally good. Different political parties sees different challenges however. Some parties sees how health in some groups are much better than in others. This has led to debate on how to improve health in the groups that are not as well off as others.";
        const nominals = this.props.contentReducer.nominals;

        let i = 0;
        let j = 0;
        const questions = this.props.contentReducer.questions.map(question => {
            let beeClass;
            if (i % 2 === 0) {
                beeClass = "top ";
                if (j % 2 === 0) {
                    beeClass += "right"
                } else {
                    beeClass += "left";
                }
            } else {
                beeClass = "bottom ";

                if (j % 2 === 0) {
                    beeClass += "right"
                } else {
                    beeClass += "left";
                }
            }
            if (i % 2 === 0) {
                j++;
            }
            i++;
            return (
                <QuestionItem
                    numOfCards={i}
                    beeClass={beeClass}
                    questionType={question.category}
                    question={question.content}
                    nominals={nominals}
                    questionObject={question}
                />
            );
        })
        let questionsIndex = 0;
        return (
            <div id="content">
                <div id="main-col">

                    <GenericItem
                        id={"theme-content"}
                        className={"mt-0"}
                        heading={"Public Health"}
                        headingLevel={1}
                        subheading={this.props.contentReducer.translation.humSubheading}
                        content={ content }
                        image={heartImage}
                    />
                    {questions[questionsIndex] ? questions[questionsIndex++] : ""}
                    <VoteItem />
                    {questions[questionsIndex] ? questions[questionsIndex++] : ""}
                    <GenericItem
                        id={"institution-content"}
                        heading={this.props.contentReducer.institution.header}
                        subheading={this.props.contentReducer.translation.institutionSubheading}
                        content={ this.props.contentReducer.institution.content }
                    />
                    {questions[questionsIndex] ? questions[questionsIndex++] : ""}
                    {questions[questionsIndex] ? questions[questionsIndex++] : ""}
                    {questions[questionsIndex] ? questions[questionsIndex++] : ""}

                    {this.props.contentReducer.numOfAnswers > 0 ? <AnswersItem /> : ""}
                </div>

                <div id="secondary-col">
                    <h2>Side content</h2>
                </div>
            </div>
        );
    }
}

const mapStateToProps = state => ({
    ...state
});

export default connect(mapStateToProps)(Content);