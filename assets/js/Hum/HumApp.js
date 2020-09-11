import React, {Component} from "react";
import Nav from "./components/Nav";
import Content from "./components/Content";

export default class HumApp extends Component {
    render() {
        return (
        <div>
            <Nav page={"home"}/>
            <Content />
        </div>
        );
    }
}