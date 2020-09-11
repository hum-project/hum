import React, {Component} from "react";
import ThemeItem from "./ThemeItem";
import QuestionItem from "./QuestionItem";

export default class Content extends Component {

    render() {
        const content = "General public health in Sweden is generally good. Different political parties sees different challenges however. Some parties sees how health in some groups are much better than in others. This has led to debate on how to improve health in the groups that are not as well off as others.";
        const nominals = ["Yes", "No"];
        return (
            <div id="content">
                <ThemeItem heading={"Public Health"} subheading={"Hum of the day"} content={ content } />
                <QuestionItem questionType={"nominal"} question={"Have you gotten the opportunity to choose a doctor when in contact with healthcare?"} nominals={nominals}/>
            </div>
        );
    }

}