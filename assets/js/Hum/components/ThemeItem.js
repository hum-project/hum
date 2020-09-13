import React, {Component} from "react";

export default class ThemeItem extends Component {

    render() {
        let image = "";
        if (this.props.image) {
            image = <img id="theme-image" src={this.props.image} alt={"theme image for " + this.props.heading} />;
        }
        return (
            <div id="theme-content" className="content-item">
                <div className="item-header">
                    <h1>{this.props.heading}</h1>
                    <p className="sub-heading">{this.props.subheading}</p>
                    { image }
                </div>

                <p>{this.props.content}</p>
            </div>
        );

    }

}