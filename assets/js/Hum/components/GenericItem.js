import React, {Component} from "react";

export default class GenericItem extends Component {

    render() {
        let image = "";
        let contentIterator = 0;
        let heading;
        if (this.props.headingLevel && this.props.headingLevel === 1) {
            heading = <h1>{this.props.heading}</h1>
        } else {
            <h2>{this.props.heading}</h2>
        }
        const content = this.props.content.split('\n').map( (key) => {
            return (
                <span key={"key" + (contentIterator++)}>
                    {key}
                    <br/>
                </span>
            );
        });
        if (this.props.image) {
            image = <img id="theme-image" src={this.props.image} alt={"theme image for " + this.props.heading} />;
        }
        return (
            <div id={this.props.id ? this.props.id : ""} className="content-item">
                <div className="item-header">
                    {heading}
                    <p className="sub-heading">{this.props.subheading}</p>
                    { image }
                </div>

                <p>{content}</p>
            </div>
        );

    }

}