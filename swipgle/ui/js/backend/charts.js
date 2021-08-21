(function() {
    'use strict';

    // New charts
    var charts = {
        // Transfers charts
        initTransfers: function() { this.AdminAllTransfersCharts(); },
        AdminAllTransfersCharts: function() {
            var urlPath = BASE_URL + '/admin/dashboard/charts/transfers';
            var request = $.ajax({
                method: 'GET',
                url: urlPath
            });

            request.done(function(response) {
                charts.CreateTransfersCharts(response);
            });
        },

        // Users charts
        initUsers: function() { this.AdminAllUsersCharts(); },
        AdminAllUsersCharts: function() {
            var urlPath = BASE_URL + '/admin/dashboard/charts/users';
            var request = $.ajax({
                method: 'GET',
                url: urlPath
            });

            request.done(function(response) {
                charts.CreateUsersCharts(response);
            });
        },


        // Create uploads charts
        CreateTransfersCharts: function(response) {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-transfers-overview'), {
                chart: {
                    type: "bar",
                    fontFamily: 'inherit',
                    height: 320,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false,
                    },
                    animations: {
                        enabled: true
                    },
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%',
                    }
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: 1,
                },
                series: [{
                    name: "Transfers",
                    data: response.transfer_count_data
                }],
                grid: {
                    padding: {
                        top: -20,
                        right: 0,
                        left: -4,
                        bottom: -4
                    },
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    categories: response.days,
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0);
                        },
                        padding: 4
                    },
                },
                colors: ["#bb07a5"],
                legend: {
                    show: false,
                },
            })).render();
        },

        // Create users charts
        CreateUsersCharts: function(response) {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-users'), {
                chart: {
                    type: "area",
                    fontFamily: 'inherit',
                    height: 240,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false,
                    },
                    animations: {
                        enabled: true
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: .16,
                    type: 'solid'
                },
                stroke: {
                    width: 2,
                    lineCap: "round",
                    curve: "smooth",
                },
                series: [{
                    name: "Users",
                    data: response.users_count_data,
                }],
                grid: {
                    padding: {
                        top: -20,
                        right: 0,
                        left: -4,
                        bottom: -4
                    },
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: 'line',
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0);
                        },
                        padding: 4
                    },
                },
                labels: response.days,
                colors: ["#0c3c94"],
                legend: {
                    show: false,
                },
            })).render();
        }
    };
    charts.initTransfers();
    charts.initUsers();
})(jQuery);