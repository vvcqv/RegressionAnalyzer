<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="manifest" href="images/site.webmanifest">
    <title>Главная страница</title>
</head>

<body>
    <?php
    require('components/header.php');
    require_once('php/connection.php');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $query = "SHOW TABLES";
    $result = mysqli_query($link, $query);
    $tables = $result->fetch_all();
    ?>
    <div class="container">
        <div class="main-form">
            <form class="form-class" method="get">
                <div class="main-form-row">
                    <select name="tablename" onchange="this.form.submit()">
                        <option value="" disabled selected>Выбор таблицы</option>
                        <?php
                        foreach ($tables as $table) {
                            if (isset($_GET["tablename"]) && $table[0] == $_GET["tablename"]) {
                        ?>
                                <option selected value="<?php echo ($table[0]) ?>"><?= $table[0] ?></option>
                            <?php
                            } else {
                            ?>
                                <option value="<?php echo ($table[0]) ?>"><?= $table[0] ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="main-form-row2">
                    <span class="main-form-row2-left">
                        <select name="axisX" onchange="this.form.submit()">
                            <option value="" disabled selected>Выбор X</option>
                            <?php
                            if (isset($_GET["tablename"])) {
                                $tablename = $_GET["tablename"];
                            } else {
                                $tablename = "default_table";
                            }
                            if (isset($_GET["tablename"])) {
                                $query = "SELECT * FROM {$tablename}";
                                $result = mysqli_query($link, $query);
                                $columns = $result->fetch_fields();
                                foreach ($columns as $val) {
                                    if ($val->type == 16 || $val->type == 1 || $val->type == 2 || $val->type == 9 || $val->type == 3 || $val->type == 8 || $val->type == 4 || $val->type == 5 || $val->type == 246) {
                                        if (isset($_GET["axisX"]) && $_GET["axisX"] == $val->name) {
                            ?>
                                            <option selected value="<?= $val->name ?>"><?= $val->name ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?= $val->name ?>"><?= $val->name ?></option>
                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                        <select name="axisY" onchange="this.form.submit()">
                            <option value="" disabled selected>Выбор Y</option>
                            <?php
                            foreach ($columns as $val) {
                                if ($val->type == 16 || $val->type == 1 || $val->type == 2 || $val->type == 9 || $val->type == 3 || $val->type == 8 || $val->type == 4 || $val->type == 5 || $val->type == 246) {
                                    if (isset($_GET["axisY"]) && $_GET["axisY"] == $val->name) {
                            ?>
                                        <option selected value="<?= $val->name ?>"><?= $val->name ?></option>
                                    <?php
                                    } else {
                                    ?>
                                        <option value="<?= $val->name ?>"><?= $val->name ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </span>
            </form>
            <span class="main-form-row2-right">
                <form action="/" method="post">
                    <button class="clear-button">Очистить</button>
                </form>
            </span>
        </div>

    </div>
    <div class="graphs">
        <?php
        $query = "SELECT * FROM {$tablename}";
        $result = mysqli_query($link, $query);
        $dataX = array();
        $dataY = array();
        if (isset($_GET["axisX"]) && isset($_GET["axisY"])) {
            $axisX = $_GET["axisX"];
            $axisY = $_GET["axisY"];

        while ($row = mysqli_fetch_array($result)) {
            array_push($dataX, $row[$axisX]);
            array_push($dataY, $row[$axisY]);
            $lastXdot = $row[$axisX];
            }
        }
        ?>
        <div class="graphs-left">
            <!-- Линейная регрессия -->
            <div class="linear">
                <div class="graph-name">Линейная регрессия</div>
                <div class="graph-chart">
                    <canvas id="myChart" width="536" height="296"></canvas>
                </div>
                <div class="graph-evaluation">
                    <div class="graph-evaluation-firstrow">
                        <div class="graph-evaluation-name">
                            Оценка модели</div>
                        <div id="graph-evaluation-formula"></div>
                    </div>
                    <div class="graph-evaluation-table">
                        <div class="table-first-row">
                            <div class="table-left">Коэффициент детерминации</div>
                            <div class="table-right">
                                <div id="r2-linear"></div>
                            </div>
                        </div>
                        <div class="table-second-row">
                            <div class="table-left">Среднеабсолютная процентная ошибка MAPE</div>
                            <div class="table-right">
                                <div id="mape-linear"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr align="left" width="544" size="1" color="#000000" />
            <!-- Степенная регрессия -->
            <div class="linear">
                <div class="graph-name">Степенная регрессия</div>
                <div class="graph-chart">
                    <canvas id="myChart3" width="536" height="296"></canvas>
                </div>
                <div class="graph-evaluation">
                    <div class="graph-evaluation-firstrow">
                        <div class="graph-evaluation-name">
                            Оценка модели</div>
                        <div id="graph-evaluation-formula-power"></div>
                    </div>
                    <div class="graph-evaluation-table">
                        <div class="table-first-row">
                            <div class="table-left">Коэффициент детерминации</div>
                            <div class="table-right">
                                <div id="r2-power"></div>
                            </div>
                        </div>
                        <div class="table-second-row">
                            <div class="table-left">Среднеабсолютная процентная ошибка MAPE</div>
                            <div class="table-right">
                                <div id="mape-power"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr align="left" width="544" size="1" color="#000000" />
            <!-- Полиноминальная регрессия 2-го порядка -->
            <div class="linear">
                <div class="graph-name">Полиноминальная регрессия 2-го порядка</div>
                <div class="graph-chart">
                    <canvas id="myChart5" width="536" height="296"></canvas>
                </div>
                <div class="graph-evaluation">
                    <div class="graph-evaluation-firstrow">
                        <div class="graph-evaluation-name">
                            Оценка модели</div>
                        <div id="graph-evaluation-formula-pol"></div>
                    </div>
                    <div class="graph-evaluation-table">
                        <div class="table-first-row">
                            <div class="table-left">Коэффициент детерминации</div>
                            <div class="table-right">
                                <div id="r2-pol"></div>
                            </div>
                        </div>
                        <div class="table-second-row">
                            <div class="table-left">Среднеабсолютная процентная ошибка MAPE</div>
                            <div class="table-right">
                                <div id="mape-pol"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr align="left" width="544" size="1" color="#000000" />
            <!-- Полиноминальная регрессия 4-го порядка -->
            <div class="linear">
                <div class="graph-name">Полиноминальная регрессия 4-го порядка</div>
                <div class="graph-chart">
                    <canvas id="myChart7" width="536" height="296"></canvas>
                </div>
                <div class="graph-evaluation">
                    <div class="graph-evaluation-firstrow">
                        <div class="graph-evaluation-name">
                            Оценка модели</div>
                        <div id="graph-evaluation-formula-pol4"></div>
                    </div>
                    <div class="graph-evaluation-table">
                        <div class="table-first-row">
                            <div class="table-left">Коэффициент детерминации</div>
                            <div class="table-right">
                                <div id="r2-pol4"></div>
                            </div>
                        </div>
                        <div class="table-second-row">
                            <div class="table-left">Среднеабсолютная процентная ошибка MAPE</div>
                            <div class="table-right">
                                <div id="mape-pol4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="graphs-right">
            <!-- Экспоненциальная регрессия -->
            <div class="linear">
                <div class="graph-name">Экспоненциальная регрессия</div>
                <div class="graph-chart">
                    <canvas id="myChart2" width="536" height="296"></canvas>
                </div>
                <div class="graph-evaluation">
                    <div class="graph-evaluation-firstrow">
                        <div class="graph-evaluation-name">
                            Оценка модели</div>
                        <div id="graph-evaluation-formula-exp"></div>
                    </div>
                    <div class="graph-evaluation-table">
                        <div class="table-first-row">
                            <div class="table-left">Коэффициент детерминации</div>
                            <div class="table-right">
                                <div id="r2-exp"></div>
                            </div>
                        </div>
                        <div class="table-second-row">
                            <div class="table-left">Среднеабсолютная процентная ошибка MAPE</div>
                            <div class="table-right">
                                <div id="mape-exp"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr align="left" width="544" size="1" color="#000000" />
            <!-- Логарифмическая регрессия -->
            <div class="linear">
                <div class="graph-name">Логарифмическая регрессия</div>
                <div class="graph-chart">
                    <canvas id="myChart4" width="536" height="296"></canvas>
                </div>
                <div class="graph-evaluation">
                    <div class="graph-evaluation-firstrow">
                        <div class="graph-evaluation-name">
                            Оценка модели</div>
                        <div id="graph-evaluation-formula-log"></div>
                    </div>
                    <div class="graph-evaluation-table">
                        <div class="table-first-row">
                            <div class="table-left">Коэффициент детерминации</div>
                            <div class="table-right">
                                <div id="r2-log"></div>
                            </div>
                        </div>
                        <div class="table-second-row">
                            <div class="table-left">Среднеабсолютная процентная ошибка MAPE</div>
                            <div class="table-right">
                                <div id="mape-log"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr align="left" width="544" size="1" color="#000000" />
            <!-- Полиноминальная регрессия 3-го порядка -->
            <div class="linear">
                <div class="graph-name">Полиноминальная регрессия 3-го порядка</div>
                <div class="graph-chart">
                    <canvas id="myChart6" width="536" height="296"></canvas>
                </div>
                <div class="graph-evaluation">
                    <div class="graph-evaluation-firstrow">
                        <div class="graph-evaluation-name">
                            Оценка модели</div>
                        <div id="graph-evaluation-formula-pol3"></div>
                    </div>
                    <div class="graph-evaluation-table">
                        <div class="table-first-row">
                            <div class="table-left">Коэффициент детерминации</div>
                            <div class="table-right">
                                <div id="r2-pol3"></div>
                            </div>
                        </div>
                        <div class="table-second-row">
                            <div class="table-left">Среднеабсолютная процентная ошибка MAPE</div>
                            <div class="table-right">
                                <div id="mape-pol3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr align="left" width="544" size="1" color="#000000" />
            <!-- Лучшая модель -->
            <div class="linear">
                <div class="graph-name" id="best-model"></div>
                <div class="graph-chart">
                    <canvas id="myChart8" width="536" height="296"></canvas>
                </div>
                <div class="graph-evaluation">
                    <div class="graph-evaluation-firstrow">
                        <div class="graph-evaluation-name">
                            Оценка модели</div>
                        <div id="graph-evaluation-formula-best"></div>
                    </div>
                    <div class="graph-evaluation-table2">
                        <div class="table-first-row2">
                            <div class="table-left">Коэффициент детерминации</div>
                            <div class="table-right">
                                <div id="r2-best"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script src="js/chartjs-plugin.js"></script>
    <script>
        <?php
        echo ("var dataXjs = " . json_encode($dataX) . ";");
        echo ("var dataYjs = " . json_encode($dataY) . ";");
        echo ("var countData = " . $lastXdot . ";");
        ?>
        dataXjs_save = dataXjs;
        dataYjs_save = dataYjs;
        result = dataXjs.map((x, i) => JSON.parse('{"x":' + x + ', "y":' + dataYjs[i] + '}'));

        const ctx = document.getElementById('myChart').getContext('2d');
        const data = {
            datasets: [{
                label: 'Dataset',
                data: result,
                backgroundColor: 'rgb(0, 113, 227)',
                regressions: {
                    line: {
                        width: 5
                    },
                    sections: [{
                        type: 'linear',
                        line: {
                            color: '#f2f2f2',
                            width: 2,
                        },
                        endIndex: countData,
                    }]
                }
            }],
        };

        const myChart = new Chart(ctx, {
            type: 'scatter',
            data: data,
            options: {
                animation: false,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    },
                },
                plugins: [{
                    legend: {
                        display: false
                    },
                }],
            },
            plugins: [
                ChartRegressions
            ],
        });
        var meta_linear = ChartRegressions.getSections(myChart, 0);

        var formula_linear = document.getElementById('graph-evaluation-formula');
        if (meta_linear[0].result.equation[1] < 0) {
            formula_linear.innerHTML += 'y = ' + meta_linear[0].result.equation[0] + 'x' + meta_linear[0].result.equation[1];
        } else if (meta_linear[0].result.equation[1] > 0) {
            formula_linear.innerHTML += 'y = ' + meta_linear[0].result.equation[0] + 'x+' + meta_linear[0].result.equation[1];
        } else {
            formula_linear.innerHTML += 'y = ' + meta_linear[0].result.equation[0] + 'x';
        }

        r2_linear = document.getElementById('r2-linear');
        r2_linear.innerHTML += 'r<sup>2</sup><sub>xy</sub> = ' + meta_linear[0].result.r2;

        var y_linear_pred = [];
        sum_linear = 0;
        var dataLength = dataXjs_save.length;
        for (let i = 0; i < dataLength; i++) {
            y_linear_pred.push(meta_linear[0].result.equation[0] * dataXjs_save[i] + meta_linear[0].result.equation[1]);
        }
        for (let i = 0; i < dataLength; i++) {
            sum_linear = sum_linear + (Math.abs(dataYjs_save[i] - y_linear_pred[i])) / dataYjs_save[i];
        }
        var mape_linear = sum_linear / dataLength * 100;
        mape_linear_dom = document.getElementById('mape-linear');
        if (mape_linear <= 1000000) {
            mape_linear_dom.innerHTML += 'MAPE = ' + mape_linear.toFixed(2) + '%';
        } else {
            mape_linear_dom.innerHTML += 'MAPE > 1,000,000%';
        }
    </script>
    <script>
        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const data2 = {
            datasets: [{
                label: 'Dataset',
                data: result,
                backgroundColor: 'rgb(0, 113, 227)',
                regressions: {
                    line: {
                        width: 5
                    },
                    sections: [{
                        type: 'exponential',
                        line: {
                            color: '#f2f2f2',
                            width: 2,
                        },
                        endIndex: countData,
                    }]
                }
            }],
        };
        const myChart2 = new Chart(ctx2, {
            type: 'scatter',
            data: data2,
            options: {
                animation: false,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    },
                },
                plugins: [{
                    legend: {
                        display: false
                    },
                }],
            },
            plugins: [
                ChartRegressions
            ],
        });
        var meta_exp = ChartRegressions.getSections(myChart2, 0);
        var formula_exp = document.getElementById('graph-evaluation-formula-exp');
        formula_exp.innerHTML += meta_exp[0].result.string;
        r2_exp = document.getElementById('r2-exp');
        r2_exp.innerHTML += 'r<sup>2</sup><sub>xy</sub> = ' + meta_exp[0].result.r2;

        var y_exp_pred = [];
        sum_exp = 0;
        for (let i = 0; i < dataLength; i++) {
            y_exp_pred.push(meta_exp[0].result.equation[0] * Math.exp(meta_exp[0].result.equation[1]) * dataXjs_save[i]);
        }
        for (let i = 0; i < dataLength; i++) {
            sum_exp = sum_exp + (Math.abs(dataYjs[i] - y_exp_pred[i])) / dataYjs[i];
        }
        var mape_exp = sum_exp / dataLength * 100;
        mape_exp_dom = document.getElementById('mape-exp');
        if (mape_exp <= 1000000) {
            mape_exp_dom.innerHTML += 'MAPE = ' + mape_exp.toFixed(2) + '%';
        } else {
            mape_exp_dom.innerHTML += 'MAPE > 1,000,000%';
        }
    </script>

    <script>
        const ctx3 = document.getElementById('myChart3').getContext('2d');
        const data3 = {
            datasets: [{
                label: 'Dataset',
                data: result,
                backgroundColor: 'rgb(0, 113, 227)',
                regressions: {
                    line: {
                        width: 5
                    },
                    sections: [{
                        type: 'power',
                        line: {
                            color: '#f2f2f2',
                            width: 2,
                        },
                        endIndex: countData,
                    }]
                }
            }],
        };
        const myChart3 = new Chart(ctx3, {
            type: 'scatter',
            data: data3,
            options: {
                animation: false,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    },
                },
                plugins: [{
                    legend: {
                        display: false
                    },
                }],
            },
            plugins: [
                ChartRegressions
            ],
        });
        var meta_power = ChartRegressions.getSections(myChart3, 0);
        var formula_power = document.getElementById('graph-evaluation-formula-power');
        formula_power.innerHTML += meta_power[0].result.string;
        r2_power = document.getElementById('r2-power');
        r2_power.innerHTML += 'r<sup>2</sup><sub>xy</sub> = ' + meta_power[0].result.r2;

        var y_power_pred = [];
        sum_power = 0;
        for (let i = 0; i < dataLength; i++) {
            y_power_pred.push(meta_power[0].result.equation[0] * dataXjs_save[i] ** meta_power[0].result.equation[1]);
        }
        for (let i = 0; i < dataLength; i++) {
            sum_power = sum_power + (Math.abs(dataYjs[i] - y_power_pred[i])) / dataYjs[i];
        }
        var mape_power = sum_power / dataLength * 100;
        mape_power_dom = document.getElementById('mape-power');
        if (mape_power <= 1000000) {
            mape_power_dom.innerHTML += 'MAPE = ' + mape_power.toFixed(2) + '%';
        } else {
            mape_power_dom.innerHTML += 'MAPE > 1,000,000%';
        }
    </script>

    <script>
        const ctx4 = document.getElementById('myChart4').getContext('2d');
        const data4 = {
            datasets: [{
                label: 'Dataset',
                data: result,
                backgroundColor: 'rgb(0, 113, 227)',
                regressions: {
                    line: {
                        width: 5
                    },
                    sections: [{
                        type: 'logarithmic',
                        line: {
                            color: '#f2f2f2',
                            width: 2,
                        },
                        endIndex: countData,
                    }]
                }
            }],
        };
        const myChart4 = new Chart(ctx4, {
            type: 'scatter',
            data: data4,
            options: {
                animation: false,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    },
                },
                plugins: [{
                    legend: {
                        display: false
                    },
                }],
            },
            plugins: [
                ChartRegressions
            ],
        });
        var meta_log = ChartRegressions.getSections(myChart4, 0);
        var formula_log = document.getElementById('graph-evaluation-formula-log');
        formula_log.innerHTML += meta_log[0].result.string;
        r2_log = document.getElementById('r2-log');
        r2_log.innerHTML += 'r<sup>2</sup><sub>xy</sub> = ' + meta_log[0].result.r2;

        var y_log_pred = [];
        sum_log = 0;
        for (let i = 0; i < dataLength; i++) {
            y_log_pred.push(meta_log[0].result.equation[0] * dataXjs_save[i] ** meta_log[0].result.equation[1]);
        }
        for (let i = 0; i < dataLength; i++) {
            sum_log = sum_log + (Math.abs(dataYjs[i] - y_log_pred[i])) / dataYjs[i];
        }
        var mape_log = sum_log / dataLength * 100;
        mape_log_dom = document.getElementById('mape-log');
        if (mape_log <= 1000000) {
            mape_log_dom.innerHTML += 'MAPE = ' + mape_log.toFixed(2) + '%';
        } else {
            mape_log_dom.innerHTML += 'MAPE > 1,000,000%';
        }
    </script>

    <script>
        const ctx5 = document.getElementById('myChart5').getContext('2d');
        const data5 = {
            datasets: [{
                label: 'Dataset',
                data: result,
                backgroundColor: 'rgb(0, 113, 227)',
                regressions: {
                    line: {
                        width: 5
                    },
                    sections: [{
                        type: 'polynomial',
                        line: {
                            color: '#f2f2f2',
                            width: 2,
                        },
                        endIndex: countData,
                    }]
                }
            }],
        };
        const myChart5 = new Chart(ctx5, {
            type: 'scatter',
            data: data5,
            options: {
                animation: false,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    },
                },
                plugins: [{
                    legend: {
                        display: false
                    },
                }],
            },
            plugins: [
                ChartRegressions
            ],
        });
        var meta_pol = ChartRegressions.getSections(myChart5, 0);
        var formula_pol = document.getElementById('graph-evaluation-formula-pol');
        formula_pol.innerHTML += meta_pol[0].result.string;
        r2_pol = document.getElementById('r2-pol');
        r2_pol.innerHTML += 'r<sup>2</sup><sub>xy</sub> = ' + meta_pol[0].result.r2;

        var y_pol_pred = [];
        sum_pol = 0;
        for (let i = 0; i < dataLength; i++) {
            y_pol_pred.push(meta_pol[0].result.equation[0] * dataXjs_save[i] ** 2 + meta_pol[0].result.equation[1] * dataXjs_save[i] + meta_pol[0].result.equation[2]);
        }
        for (let i = 0; i < dataLength; i++) {
            sum_pol = sum_pol + (Math.abs(dataYjs[i] - y_pol_pred[i])) / dataYjs[i];
        }
        var mape_pol = sum_pol / dataLength * 100;
        mape_pol_dom = document.getElementById('mape-pol');
        if (mape_pol <= 1000000) {
            mape_pol_dom.innerHTML += 'MAPE = ' + mape_pol.toFixed(2) + '%';
        } else {
            mape_pol_dom.innerHTML += 'MAPE > 1,000,000%';
        }
    </script>

    <script>
        const ctx6 = document.getElementById('myChart6').getContext('2d');
        const data6 = {
            datasets: [{
                label: 'Dataset',
                data: result,
                backgroundColor: 'rgb(0, 113, 227)',
                regressions: {
                    line: {
                        width: 5
                    },
                    sections: [{
                        type: 'polynomial3',
                        line: {
                            color: '#f2f2f2',
                            width: 2,
                        },
                        endIndex: countData,
                    }]
                }
            }],
        };
        const myChart6 = new Chart(ctx6, {
            type: 'scatter',
            data: data6,
            options: {
                animation: false,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    },
                },
                plugins: [{
                    legend: {
                        display: false
                    },
                }],
            },
            plugins: [
                ChartRegressions
            ],
        });
        var meta_pol3 = ChartRegressions.getSections(myChart6, 0);
        var formula_pol3 = document.getElementById('graph-evaluation-formula-pol3');
        formula_pol3.innerHTML += meta_pol3[0].result.string;
        r2_pol3 = document.getElementById('r2-pol3');
        r2_pol3.innerHTML += 'r<sup>2</sup><sub>xy</sub> = ' + meta_pol3[0].result.r2;

        var y_pol3_pred = [];
        sum_pol3 = 0;
        for (let i = 0; i < dataLength; i++) {
            y_pol3_pred.push(meta_pol3[0].result.equation[0] * dataXjs_save[i] ** 3 + meta_pol3[0].result.equation[1] * dataXjs_save[i] ** 2 + meta_pol3[0].result.equation[2] * dataXjs_save[i] + meta_pol3[0].result.equation[3]);
        }
        for (let i = 0; i < dataLength; i++) {
            sum_pol3 = sum_pol3 + (Math.abs(dataYjs[i] - y_pol3_pred[i])) / dataYjs[i];
        }
        var mape_pol3 = sum_pol3 / dataLength * 100;
        mape_pol3_dom = document.getElementById('mape-pol3');
        if (mape_pol3 <= 1000000) {
            mape_pol3_dom.innerHTML += 'MAPE = ' + mape_pol3.toFixed(2) + '%';
        } else {
            mape_pol3_dom.innerHTML += 'MAPE > 1,000,000%';
        }
    </script>

    <script>
        const ctx7 = document.getElementById('myChart7').getContext('2d');
        const data7 = {
            datasets: [{
                label: 'Dataset',
                data: result,
                backgroundColor: 'rgb(0, 113, 227)',
                regressions: {
                    line: {
                        width: 5
                    },
                    sections: [{
                        type: 'polynomial4',
                        line: {
                            color: '#f2f2f2',
                            width: 2,
                        },
                        endIndex: countData,
                    }]
                }
            }],
        };
        const myChart7 = new Chart(ctx7, {
            type: 'scatter',
            data: data7,
            options: {
                animation: false,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    },
                },
                plugins: [{
                    legend: {
                        display: false
                    },
                }],
            },
            plugins: [
                ChartRegressions
            ],
        });
        var meta_pol4 = ChartRegressions.getSections(myChart7, 0);
        console.log(meta_pol4);
        var formula_pol4 = document.getElementById('graph-evaluation-formula-pol4');
        formula_pol4.innerHTML += meta_pol4[0].result.string;
        r2_pol4 = document.getElementById('r2-pol4');
        r2_pol4.innerHTML += 'r<sup>2</sup><sub>xy</sub> = ' + meta_pol4[0].result.r2;

        var y_pol4_pred = [];
        sum_pol4 = 0;
        for (let i = 0; i < dataLength; i++) {
            y_pol4_pred.push(meta_pol4[0].result.equation[0] * dataXjs_save[i] ** 4 + meta_pol4[0].result.equation[1] * dataXjs_save[i] ** 3 + meta_pol4[0].result.equation[2] * dataXjs_save[i] ** 2 + meta_pol4[0].result.equation[3] * dataXjs_save[i] + meta_pol4[0].result.equation[4]);
        }
        for (let i = 0; i < dataLength; i++) {
            sum_pol4 = sum_pol4 + (Math.abs(dataYjs[i] - y_pol4_pred[i])) / dataYjs[i];
        }
        var mape_pol4 = sum_pol4 / dataLength * 100;
        mape_pol4_dom = document.getElementById('mape-pol4');
        if (mape_pol4 <= 1000000) {
            mape_pol4_dom.innerHTML += 'MAPE = ' + mape_pol4.toFixed(2) + '%';
        } else {
            mape_pol4_dom.innerHTML += 'MAPE > 1,000,000%';
        }
    </script>

    <script>
        const ctx8 = document.getElementById('myChart8').getContext('2d');
        const data8 = {
            datasets: [{
                label: 'Dataset',
                data: result,
                backgroundColor: 'rgb(0, 113, 227)',
                regressions: {
                    line: {
                        width: 5
                    },
                    sections: [{
                        type: ['linear', 'exponential', 'power', 'polynomial', 'polynomial3', 'polynomial4', 'logarithmic'],
                        line: {
                            color: '#f2f2f2',
                            width: 2,
                        },
                        endIndex: countData,
                    }]
                }
            }],
        };
        const myChart8 = new Chart(ctx8, {
            type: 'scatter',
            data: data8,
            options: {
                animation: false,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    },
                },
                plugins: [{
                    legend: {
                        display: false
                    },
                }],
            },
            plugins: [
                ChartRegressions
            ],
        });
        var meta_best = ChartRegressions.getSections(myChart8, 0);
        console.log(meta_best);
        var formula_best = document.getElementById('graph-evaluation-formula-best');
        formula_best.innerHTML += meta_best[0].result.string;
        r2_best = document.getElementById('r2-best');
        r2_best.innerHTML += 'r<sup>2</sup><sub>xy</sub> = ' + meta_best[0].result.r2;

        best_model_name = document.getElementById('best-model');
        best_model_type = meta_best[0].result.type;
        switch (best_model_type) {
            case "linear":
                best_model_type = "линейная";
                break;
            case "exponential":
                best_model_type = "экспоненциальная";
                break;
            case "power":
                best_model_type = "степенная";
                break;
            case "polynomial":
                best_model_type = "полиноминальная 2-го порядка";
                break;
            case "polynomial3":
                best_model_type = "полиноминальная 3-го порядка";
                break;
            case "polynomial4":
                best_model_type = "полиноминальная 4-го порядка";
                break;
        }
        best_model_name.innerHTML += 'Лучшая модель - ' + best_model_type;
    </script>
    <?php
    $link->close();
    ?>
</body>

</html>
