import React, {Component} from "react";
import CircleDiagram from "./CircleDiagram";

export default class VoteItem extends Component {

    render() {
        const svenska = {
            yes: 'Ja',
            no: 'Nej',
            abstain: 'Avstår',
            absent: 'Frånvaro',
            source: 'Källa'
        }
        const english = {
            yes: 'Yes',
            no: 'No',
            abstain: 'Abstain',
            absent: 'Absent',
            source: 'Source'
        }
        let translation;
        let source;
        let voteSign;
        if (this.props.language) {
            translation = this.props.language.toLowerCase() === "swedish" ||
                this.props.language.toLowerCase() === "svenska" ?
                svenska : english;
        } else {
            translation = english;
        }
        voteSign = this.props.vote.yes > this.props.vote.no ? <span className="vote-sign yes">✓</span> : <span className="vote-sign no">✕</span>;

        source = this.props.source ? <p>{translation.source}: <a href={this.props.source}>{this.props.source}</a></p> : "";
        return (
            <div className="vote-item content-item">
                <div className="item-header">
                    <h1>{this.props.heading}</h1>
                    <p className="sub-heading">{this.props.subheading}</p>
                </div>
                <p>{this.props.content}</p>
                { source }

                <div className="vote-result">
                    <div className="vote-sign-container">
                        { voteSign }
                    </div>
                    <div className="result-summary">
                        <p>{translation.yes}:</p><p>{this.props.vote.yes}</p>
                        <p>{translation.no}:</p><p>{this.props.vote.no}</p>
                        <p>{translation.abstain}:</p><p>{this.props.vote.abstain}</p>
                        <p className="cursive">{translation.absent}:</p><p>{this.props.vote.absent}</p>
                    </div>
                    <CircleDiagram />
                </div>
            </div>
        );
    }

}