import React, {Component} from "react";
import AnswerButton from "./AnswerButton";

export default class QuestionItem extends Component {

    render() {
        let answer = "";
        let index = 0;
        let cards = <div className="card">?</div>
        if (this.props.questionType === "nominal") {
            answer = this.props.nominals.map(option => <AnswerButton key={option + (index++)} text={option}/>)
        } else if (this.props.questionType === "ordinal") {

        } else {

        }
        return (
            <div className="question-item">
                <div className="cards-container">
                    { cards }
                </div>
                <div className="question-content">
                    <p>{this.props.question}</p>
                    <div>
                        { answer }
                    </div>
                </div>
            </div>
        );
    }

}