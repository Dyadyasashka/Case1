document.addEventListener('DOMContentLoaded', function () {
    // Проверка наличия элементов DOM
    var currentValueData = document.getElementById('currentValueData');
    var buttonsContainer = document.getElementById('chartButtons');
    var canvas = document.getElementById('currentValueChart');
    var toggleLegendButton = document.getElementById('toggleLegendButton');

    if (!currentValueData || !buttonsContainer || !canvas || !toggleLegendButton) {
        console.error('Не найдены необходимые элементы DOM.');
        return;
    }

    var dataPoints = JSON.parse(currentValueData.getAttribute('data-data'));
    var meter_id = currentValueData.getAttribute('data-meter_id');
    var currentValueChart;
    var selectedType = localStorage.getItem('selectedType');

    var legendLabels = {
        voltage: ['Напряжение по фазе А (В)', 'Напряжение по фазе В (В)', 'Напряжение по фазе С (В)'],
        current: ['Ток по фазе А (А)', 'Ток по фазе В (А)', 'Ток по фазе С (А)'],
        activePower: ['Активная мощность по фазе А (кВт)', 'Активная мощность по фазе B (кВт)', 'Активная мощность по фазе C (кВт)', 'Активная мощность по сумме фаз (кВт)'],
        reactivePower: ['Реактивная мощность по фазе А (кВАр)', 'Реактивная мощность по фазе B (кВАр)', 'Реактивная мощность по фазе C (кВАр)', 'Реактивная мощность по сумме фаз (кВАр)'],
        fullPower: ['Полная мощность по фазе А (кВА)', 'Полная мощность по фазе B (кВА)', 'Полная мощность по фазе C (кВА)', 'Полная мощность по сумме фаз (кВА)'],
        powerFactor: ['Коэффициент мощности по фазе А', 'Коэффициент мощности по фазе В', 'Коэффициент мощности по фазе С', 'Коэффициент мощности по сумме фаз'],
        angle: ['Угол между фазными напряжениями фаз А и В (°)', 'Угол между фазными напряжениями фаз В и С (°)', 'Угол между фазными напряжениями фаз А и С (°)'],
        frequency: ['Частота сети (Гц)'],
    };

    buttonsContainer.addEventListener('click', function (event) {
        if (event.target && event.target.id.startsWith('button_')) {
            var type = event.target.id.split('_')[1];
            handleButtonClick(type);
        }
    });

    toggleLegendButton.addEventListener('click', function() {
        var legend = currentValueChart.legend;
        legend.options.display = !legend.options.display;
        currentValueChart.update();
        if (legend.options.display) {
            toggleLegendButton.textContent = 'Скрыть';
        } else {
            toggleLegendButton.textContent = 'Показать';
        }
    });

    if (dataPoints.length > 0) {
        createChart();
    } else {
        createEmptyChart();
    }
    
    function handleButtonClick(type) {
        window.location.href = '/currentvalue/' + meter_id + '/' + type;
        localStorage.setItem('selectedType', type);

        var buttons = buttonsContainer.querySelectorAll('button');
        buttons.forEach(function (button) {
            button.classList.remove('active');
        });
    
        var activeButton = document.getElementById('button_' + type);
        activeButton.classList.add('active');
    }

    function updateLegend(type) {
        var datasetIndex = Object.keys(legendLabels).indexOf(type);
        if (datasetIndex !== -1) {
            currentValueChart.data.datasets.forEach(function (dataset, index) {
                dataset.label = legendLabels[type][index] || '';
            });
            currentValueChart.update();
        }
    }
    
    function createChart(){

        var labelsWithoutHours  = [];
        var previousDate = '';

        dataPoints.forEach(function (point) {

            var datePart = point.date.split(' ')[0].split('.').slice(0, 2).join('.');
            var timePart = point.date.split(' ')[1].split(':').slice(0, 2).join(':');
            var currentDate = datePart + ' ' + timePart;

            if (currentDate !== previousDate) {
                labelsWithoutHours.push(currentDate);
                previousDate = currentDate;
            } else {
                labelsWithoutHours.push('');
            }
        });

        var datasets = [];
        var headers = Object.keys(dataPoints[0]);
        var lineColors = ['rgb(219,176,65)', 'rgb(81,163,81)', 'rgb(219,86,65)','rgb(45,112,137)'];

        headers.forEach(function (header, index) {
            if (header !== 'date') {
                var values = dataPoints.map(function (point) {
                    return point[header];
                });
    
                var dataset = {
                    label: header,
                    data: values,
                    borderWidth: 1,
                    fill: false,
                    showLine: true,
                    pointRadius: 0,
                };
    
                if (index >= 1 && index <= 4) {
                    dataset.borderColor = lineColors[index - 1];
                    dataset.backgroundColor = lineColors[index - 1];
                }
    
                datasets.push(dataset);
            }
        });

        var ctx = canvas.getContext('2d');
        var parentElement = canvas.parentElement;
        var containerWidth = parentElement.clientWidth;
        canvas.width = containerWidth;

        var chartConfig = {
            type: 'line',
            data: {
                labels: [],
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false , 
                        position: 'top',
                        align: 'start', 
                    },
                    zoom: {
                        zoom: {
                            wheel: {
                                enabled: true
                            },
                            pinch: {
                                enabled: true
                            },
                            mode: 'x'
                        }
                    }
                },
                tooltips: {
                    callbacks: {
                        title: function (tooltipItems, data) {
                            var tooltipItem = tooltipItems[0];
                            var index = tooltipItem.index;
                            return data.labels[index];
                        },
                        label: function (tooltipItem, data) {
                            return tooltipItem.yLabel.toFixed(2);
                        },
                    },
                },
                scales: {
                    x: {
                        labels: labelsWithoutHours,
                    }
                }, 
            },
        };
        
        currentValueChart = new Chart(ctx, chartConfig);
        
        if (selectedType) {
            updateLegend(selectedType);
            var activeButton = document.getElementById('button_' + selectedType);
            activeButton.classList.add('active');
        }  
    }

    function createEmptyChart() {
        var ctx = canvas.getContext('2d');
        var parentElement = canvas.parentElement;
        var containerWidth = parentElement.clientWidth;
        canvas.width = containerWidth;
    
        var emptyChartConfig = {
            type: 'bar',
            data: {
                labels: [],
                datasets:  [{
                    label: 'нет данных',
                    data: Array(1).fill(200),
                    backgroundColor: 'rgb(255, 0, 0)',
                    borderWidth: 1
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    zoom: {
                        zoom: {
                            wheel: {
                                enabled: true
                            },
                            pinch: {
                                enabled: true
                            },
                            mode: 'x'
                        }
                    }
                },
                scales: {
                    x: {
                        labels: ['Данный счетчик не поддерживает выбранное значения'],
                    }
                },
            },
        };
    
        currentValueChart = new Chart(ctx, emptyChartConfig);
    }

});