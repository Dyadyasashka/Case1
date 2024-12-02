document.addEventListener('DOMContentLoaded', function () {
    // Проверка наличия элементов DOM
    var powerProfileData = document.getElementById('powerProfileData');
    var canvas = document.getElementById('powerProfileChart');
    var toggleLegendButton = document.getElementById('toggleLegendButton');
    var groupSelect = document.getElementById('groupSelect');

    if (!powerProfileData || !canvas ) {
        console.error('Не найдены необходимые элементы DOM.');
        return;
    }

    var dataPoints = JSON.parse(powerProfileData.getAttribute('data-data'));
    var powerProfileChart;
    var savedValue = localStorage.getItem('selectedGroup');

    toggleLegendButton.addEventListener('click', function() {
        var legend = powerProfileChart.legend;
        legend.options.display = !legend.options.display;
        powerProfileChart.update();
        if (legend.options.display) {
            toggleLegendButton.textContent = 'Скрыть';
        } else {
            toggleLegendButton.textContent = 'Показать';
        }
    });

    function createPowerData(label, values, borderColor, backgroundColor) {
        return {
            label: label,
            data: values,
            borderColor: borderColor,
            backgroundColor: backgroundColor,
            borderWidth: 1,
            fill: false,
            showLine: true,
            pointRadius: 0,
        };
    }

    function getPowerValues(dataPoints, property) {
        return dataPoints.map(function (point) {
            return point[property];
        });
    }

    function createChart(labels, labelsWithoutHours, activePowerData, reverseActivePowerData, reactivePowerData, reverseReactivePowerData) {

        var ctx = canvas.getContext('2d');
        var parentElement = canvas.parentElement;
        var containerWidth = parentElement.clientWidth;
        canvas.width = containerWidth;

        var chartConfig = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [activePowerData, reverseActivePowerData, reactivePowerData, reverseReactivePowerData]
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
                }    
            },
        };
        
        powerProfileChart = new Chart(ctx, chartConfig);
        
    }

    if (dataPoints.length > 0) {

        var labels = dataPoints.map(function (point) {
            return point.date;
        });

        var labelsWithoutHours  = [];
        var previousDate = '';

        dataPoints.forEach(function (point) {
            var currentDate = point.date.split(' ')[0].split('.').slice(0, 2).join('.');

            if (currentDate !== previousDate) {
                labelsWithoutHours.push(currentDate);
                previousDate = currentDate;
            } else {
                labelsWithoutHours.push('');
            }
        });

        groupSelect.addEventListener('change', function () {
            var selectedValue = groupSelect.value;
            localStorage.setItem('selectedGroup', selectedValue);
        });
        
        if (savedValue) {
            groupSelect.value = savedValue;
        }

        var activePowerValues = getPowerValues(dataPoints, 'active_power');
        var reverseActivePowerValues = getPowerValues(dataPoints, 'reverse_active_power');
        var reactivePowerValues = getPowerValues(dataPoints, 'reactive_power');
        var reverseReactivePowerValues = getPowerValues(dataPoints, 'reverse_reactive_power');

        var activePowerData = createPowerData('Активная мощность', activePowerValues, 'rgb(36,133,179)', 'rgb(36,133,179)');
        var reverseActivePowerData = createPowerData('Обратная активная мощность', reverseActivePowerValues, 'rgb(179,169,36)', 'rgb(179,169,36)')
        var reactivePowerData = createPowerData('Реактивная мощность', reactivePowerValues, 'rgb(179,55,55)', 'rgb(179,55,55)');
        var reverseReactivePowerData = createPowerData('Обратная реактивная мощность', reverseReactivePowerValues, 'rgb(55,179,101)', 'rgb(55,179,101)')

        createChart(labels, labelsWithoutHours, activePowerData, reverseActivePowerData, reactivePowerData, reverseReactivePowerData);
    } else {

        var ctx = canvas.getContext('2d');
        var parentElement = canvas.parentElement;
        var containerWidth = parentElement.clientWidth;
        canvas.width = containerWidth;
    
        var xLabels = Array.from({ length: 31 }, (_, i) => (i + 1).toString());
        var yLabels = Array.from({ length: 9 }, (_, i) => (i * 50).toString());
    
        var emptyChartConfig = {
            type: 'bar',
            data: {
                labels: xLabels,
                datasets: [{
                    label: 'За данный период нет доступных профилей мощности.',
                    data: Array(31).fill(400),
                    backgroundColor: 'rgb(255, 0, 0)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                        },
                        suggestedMin: 0,
                        suggestedMax: 450
                    }
                }
            }
        };
    
        powerProfileChart = new Chart(ctx, emptyChartConfig);

    }
});
