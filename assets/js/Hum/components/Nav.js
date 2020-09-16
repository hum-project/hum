import React, {Component} from "react";
import Logo from "./Logo";
import NavItem from "./NavItem";

export default class Nav extends Component {
    render() {
        return (
            <header>
                <Logo />
                <nav>
                    <div>
                        <div id="main-nav">
                            <NavItem id={"home"} current={this.props.page === "home"} navPath={"/"} text={"Home"} />
                            <NavItem id={"library"} current={this.props.page === "library"} navPath={"#"} text={"Library"} />
                            <NavItem id={"about"} current={this.props.page === "about"} navPath={"#"} text={"About"} />
                            <NavItem id={"contact"} current={this.props.page === "contact"} navPath={"#"} text={"Contact"} />
                        </div>
                    </div>
                </nav>
            </header>
        );
    }
}