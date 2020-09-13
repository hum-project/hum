import React, { Component } from "react";
import { Doughnut } from "react-chartjs-2";

export default class CircleDiagram extends Component {
    render() {
        const percentage = Math.round(233.0 / (233.0 + 54.0 + 11.0) * 100);
        const data = {
            labels: ['Yes', 'No', 'Abstain' ],
            datasets: [
                {
                    label: 'Voting',
                    backgroundColor: [
                        '#5eb5e0',
                        '#e0695e',
                        '#e0e0e0'
                    ],
                    hoverBackgroundColor: [
                        '#2e596e',
                        '#602d28',
                        '#5a5a5a'
                    ],
                    data: [ 233, 54, 11 ]
                }
            ]
        };
        return (
            <div className="diagram-container">
                <div className="center-artefact">
                    {percentage + "%"}
                </div>
                <Doughnut
                    data={ data }
                    options={{
                        legend:{
                            display:false,
                        },
                        responsive : true,
                        maintainAspectRatio: true,
                        cutoutPercentage: 75
                    }}
                />
            </div>
        );
    }
}