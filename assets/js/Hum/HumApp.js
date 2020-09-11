import React, {Component} from "react";
import Nav from "./components/Nav";

export default class HumApp extends Component {
    render() {
        return (
        <div>
            <Nav page={"home"}/>
            <h2>Real (kinda) history</h2>
            <p>{this.props.humData}</p>
        </div>
        );
    }
}