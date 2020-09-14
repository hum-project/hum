import React, {Component} from "react";
import {connect} from "react-redux";

class AnswersItem extends Component {

    render() {

        return (
            <div id={this.props.id ? this.props.id : ""} className="content-item">
                <div className="item-header center">
                    <h2 className="bold">{this.props.contentReducer.translation.answersHeading}</h2>

                </div>
                <p>{this.props.contentReducer.translation.answersContent}</p>


            </div>
        );

    }

}

const mapStateToProps = state => ({
    ...state
});

export default connect(mapStateToProps)(AnswersItem);