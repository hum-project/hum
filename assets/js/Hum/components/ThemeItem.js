import React, {Component} from "react";

export default class ThemeItem extends Component {

    render() {
        let image = "";
        if (this.props.image) {
            image = <img src={image} alt={"theme image for " + this.props.heading} />;
        }
        return (
            <div id="theme-content" className="content-item">
                <div className="item-header">
                    <p className="sub-heading">{this.props.subheading}</p>
                    <h1>{this.props.heading}</h1>
                    { image }
                </div>

                <p>{this.props.content}</p>
            </div>
        );

    }

}