import React, {Component} from "react";
import {connect} from "react-redux";
import AnswerButton from "./AnswerButton";
import bee from "../../../images/small-bee@2x.png"

class QuestionItem extends Component {

    render() {
        let answer = "";
        let index = 0;
        let cards = <div className="card">?</div>
        let beeClass = this.props.beeClass ? this.props.beeClass : "";

        if (this.props.questionObject.answerOptions.category === "nominal") {
            answer = this.props.questionObject.answerOptions.values.map(option => <AnswerButton questionObject={this.props.questionObject} key={option + (index++)} text={option}/>)
        } else if (this.props.questionType === "ordinal") {

        } else {

        }
        return (
            <div className="question-item">
                <img className={"question-bee " + beeClass} src={bee} alt="A small bumblebee"/>
                <div className="cards-container">
                    { cards }
                </div>
                <div className="question-content">
                    <p>{this.props.questionObject.content}</p>
                    <div>
                        { answer }
                    </div>
                </div>
            </div>
        );
    }

}

const mapStateToProps = state => ({
    ...state
});

export default connect(mapStateToProps)(QuestionItem);