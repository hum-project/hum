import React, {Component} from "react";

export default class AnswerButton extends Component {

    render() {
        let symbol = "";
        if (this.props.text.toLowerCase() === "yes" || this.props.text.toLowerCase() === "ja") {
            symbol = <span className="symbol">✓</span>;
        } else if (this.props.text.toLowerCase() === "no" || this.props.text.toLowerCase() === "nej") {
            symbol = <span className="symbol">✕</span>;
        }
        return (
            <button className="answer-option">{symbol}{this.props.text.toUpperCase()}</button>
        );
    }

}