// Chart.js

var randomScalingFactor = function () {
    return Math.round(Math.random() * 100);
};

var MONTHS = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
];

chartColors = {
    red: "#dc3545",
    orange: "#fd7e14",
    yellow: "#ffc107",
    green: "#28a745",
    blue: "#007bff",
    purple: "#6f42c1",
    grey: "#6c757d",
};

var color = Chart.helpers.color;
var barChartData = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "Dataset 1",
            backgroundColor: color(chartColors.red).alpha(0.5).rgbString(),
            borderColor: chartColors.red,
            borderWidth: 1,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
            ],
        },
        {
            label: "Dataset 2",
            backgroundColor: color(chartColors.blue).alpha(0.5).rgbString(),
            borderColor: chartColors.blue,
            borderWidth: 1,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
            ],
        },
    ],
};

/*var configPie = {
  type: "pie",
  data: {
    datasets: [
      {
        data: [
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
        ],
        backgroundColor: [
          chartColors.red,
          chartColors.orange,
          chartColors.yellow,
          chartColors.green,
          chartColors.blue,
        ],
        label: "Dataset 1",
      },
    ],
    labels: ["Quatrième","3ème", "2nde", "1ère", "Terminale"],
  },
  options: {
    responsive: true,
  },
};*/

var barChartData = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "Dataset 1",
            backgroundColor: chartColors.red,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
            ],
        },
        {
            label: "Dataset 2",
            backgroundColor: chartColors.blue,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
            ],
        },
        {
            label: "Dataset 3",
            backgroundColor: chartColors.green,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
            ],
        },
    ],
};

var configRadar = {
    type: "radar",
    data: {
        labels: [
            ["Eating", "Dinner"],
            ["Drinking", "Water"],
            "Sleeping",
            ["Designing", "Graphics"],
            "Coding",
            "Cycling",
            "Running",
        ],
        datasets: [
            {
                label: "My First dataset",
                backgroundColor: color(chartColors.red).alpha(0.2).rgbString(),
                borderColor: chartColors.red,
                pointBackgroundColor: chartColors.red,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
            },
            {
                label: "My Second dataset",
                backgroundColor: color(chartColors.blue).alpha(0.2).rgbString(),
                borderColor: chartColors.blue,
                pointBackgroundColor: chartColors.blue,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
            },
        ],
    },
    options: {
        legend: {
            position: "top",
        },
        title: {
            display: false,
            text: "Chart.js Radar Chart",
        },
        scale: {
            ticks: {
                beginAtZero: true,
            },
        },
    },
};


/*var configDoughnut2 = {
  type: "doughnut",
  data: {
    datasets: [
      {
        data: [
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
        ],
        backgroundColor: [
          chartColors.red,
          chartColors.orange,
          chartColors.yellow,
          chartColors.green,
          chartColors.blue,
        ],
        label: "Dataset 1",
      },
    ],
    labels: ["Red", "Orange", "Yellow", "Green", "Blue"],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    legend: {
      display: false,
    },
    title: {
      display: false,
      text: "Chart.js Doughnut Chart",
    },
    animation: {
      animateScale: true,
      animateRotate: true,
    },
  },
};*/

var configPolar = {
    data: {
        datasets: [
            {
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
                backgroundColor: [
                    color(chartColors.red).alpha(0.5).rgbString(),
                    color(chartColors.orange).alpha(0.5).rgbString(),
                    color(chartColors.yellow).alpha(0.5).rgbString(),
                    color(chartColors.green).alpha(0.5).rgbString(),
                    color(chartColors.blue).alpha(0.5).rgbString(),
                ],
                label: "My dataset", // for legend
            },
        ],
        labels: ["Red", "Orange", "Yellow", "Green", "Blue"],
    },
    options: {
        responsive: true,
        legend: {
            position: "right",
        },
        title: {
            display: false,
            text: "Chart.js Polar Area Chart",
        },
        scale: {
            ticks: {
                beginAtZero: true,
            },
            reverse: false,
        },
        animation: {
            animateRotate: false,
            animateScale: true,
        },
    },
};

var configLine = {
    type: "line",
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [
            {
                label: "My First dataset",
                backgroundColor: chartColors.red,
                borderColor: chartColors.red,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
                fill: false,
            },
            {
                label: "My Second dataset",
                fill: false,
                backgroundColor: chartColors.blue,
                borderColor: chartColors.blue,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        title: {
            display: false,
            text: "Chart.js Line Chart",
        },
        legend: {
            display: false,
        },
        layout: {
            padding: {
                left: 10,
                right: 10,
                top: 10,
                bottom: 0,
            },
        },
        tooltips: {
            mode: "index",
            intersect: false,
        },
        hover: {
            mode: "nearest",
            intersect: true,
        },
        pointBackgroundColor: "#fff",
        pointBorderColor: chartColors.blue,
        pointBorderWidth: "2",
        scales: {
            xAxes: [
                {
                    display: false,
                    scaleLabel: {
                        display: true,
                        labelString: "Month",
                    },
                },
            ],
            yAxes: [
                {
                    display: false,
                    scaleLabel: {
                        display: true,
                        labelString: "Value",
                    },
                },
            ],
        },
    },
};

var horizontalBarChartData = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "Dataset 1",
            backgroundColor: color(chartColors.red).alpha(0.5).rgbString(),
            borderColor: chartColors.red,
            borderWidth: 1,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
            ],
        },
        {
            label: "Dataset 2",
            backgroundColor: color(chartColors.blue).alpha(0.5).rgbString(),
            borderColor: chartColors.blue,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
            ],
        },
    ],
};

window.onload = function () {
    //Bar

    if (document.getElementById("canvas")) {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: "bar",
            data: barChartData,
            options: {
                responsive: true,
                legend: {
                    position: "top",
                },
                title: {
                    display: false,
                    text: "Chart.js Bar Chart",
                },
            },
        });
    }

    // Pie

    if (document.getElementById("chart-area")) {
        var ctx2 = document.getElementById("chart-area").getContext("2d");
        window.myPie = new Chart(ctx2, configPie);
    }

    // Doughnut

    if (document.getElementById("doughnut-chart")) {
        var ctx3 = document.getElementById("doughnut-chart").getContext("2d");
        window.myDoughnut = new Chart(ctx3, configDoughnut);
    }

    if (document.getElementById("doughnut-chart-2")) {
        var ctx33 = document.getElementById("doughnut-chart-2").getContext("2d");
        window.myDoughnut = new Chart(ctx33, configDoughnut2);
    }

    if (document.getElementById("doughnut-chart-3")) {
        var ctx333 = document.getElementById("doughnut-chart-3").getContext("2d");
        window.myDoughnut = new Chart(ctx333, configDoughnut3);
    }

    if (document.getElementById("doughnut-chart-4")) {
        var ctx3333 = document.getElementById("doughnut-chart-4").getContext("2d");
        window.myDoughnut = new Chart(ctx3333, configDoughnut4);
    }

    if (document.getElementById("doughnut-chart-5")) {
        var ctx33333 = document.getElementById("doughnut-chart-5").getContext("2d");
        window.myDoughnut = new Chart(ctx33333, configDoughnut5);
    }

    if (document.getElementById("doughnut-chart-8")) {
        var ctx8 = document.getElementById("doughnut-chart-8").getContext("2d");
        window.myDoughnut = new Chart(ctx8, configDoughnut8);
    }

    // Radar

    if (document.getElementById("radar-chart")) {
        window.myRadar = new Chart(
            document.getElementById("radar-chart"),
            configRadar
        );
    }

    // Polar

    if (document.getElementById("polar-chart")) {
        var ctx4 = document.getElementById("polar-chart");
        window.myPolarArea = Chart.PolarArea(ctx4, configPolar);
    }

    // Line

    if (document.getElementById("line-chart")) {
        var ctx5 = document.getElementById("line-chart").getContext("2d");
        window.myLine = new Chart(ctx5, configLine);
    }

    if (document.getElementById("chart-horiz-bar")) {
        var ctx6 = document.getElementById("chart-horiz-bar").getContext("2d");
        window.myHorizontalBar = new Chart(ctx6, {
            type: "horizontalBar",
            data: horizontalBarChartData,
            options: {
                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each horizontal bar to be 2px wide
                elements: {
                    rectangle: {
                        borderWidth: 2,
                    },
                },
                responsive: true,
                legend: {
                    position: "right",
                },
                title: {
                    display: false,
                    text: "Chart.js Horizontal Bar Chart",
                },
            },
        });
    }

    if (document.getElementById("stacked-bars-chart")) {
        var ctx7 = document.getElementById("stacked-bars-chart").getContext("2d");
        window.myBar = new Chart(ctx7, {
            type: "bar",
            data: barChartData,
            options: {
                title: {
                    display: true,
                    text: "Chart.js Bar Chart - Stacked",
                },
                tooltips: {
                    mode: "index",
                    intersect: false,
                },
                responsive: true,
                scales: {
                    xAxes: [
                        {
                            stacked: true,
                        },
                    ],
                    yAxes: [
                        {
                            stacked: true,
                        },
                    ],
                },
            },
        });
    }

    if (document.getElementById("doughnut-chart-8")) {
        var ctx8 = document.getElementById("doughnut-chart-8").getContext("2d");
    }
};
