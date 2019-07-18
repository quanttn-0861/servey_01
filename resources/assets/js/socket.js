$(document).ready(function () {
    var host = $('.data').data('host');
    var port = $('.data').data('port');
    var link = (port == '') ? host : host + ":" + port;
    var socket = io.connect(link);

    function paintChart() {
        var number = parseInt($('.ct-data').attr('data-number'));
        var charts = $('.ct-data').attr('data-content');

        if (charts) {

            var obj = jQuery.parseJSON(charts);

            for (i = 0; i < obj.length; i++) {
                var dataInput = new Array();

                for (j = 0; j < obj[i]['chart'].length; j++) {
                    dataInput.push([obj[i]['chart'][j]['answer'], obj[i]['chart'][j]['percent']]);
                }

                var count = i + 1;

                if (dataInput.length != 1) {
                    Highcharts.chart('container' + i, {
                        chart: {
                            type: 'pie',
                            options3d: {
                                enabled: true,
                                alpha: 45,
                                beta: 0
                            },
                            style: {
                                fontFamily: 'Arial'
                            },
                            spacingBottom: 15,
                            spacingTop: 0,
                            spacingLeft: 70,
                            spacingRight: 70,
                        },
                        title: {
                            text: ''
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                depth: 35,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.percentage:.1f} %',
                                    distance: -50,
                                    filter: {
                                        property: 'percentage',
                                        operator: '>',
                                        value: 4
                                    }
                                },
                                showInLegend: true
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: 'Browser share',
                            data: dataInput
                        }]
                    });
                }
            }
        }
    }

    $(function () {
        paintChart();
    });

    socket.on('answer', function (data) {
        var socketData = $.parseJSON(data);

        if (socketData.success) {
            $('.home' + socketData.surveyId).html(socketData.viewChart);
            $('.menu1' + socketData.surveyId).html(socketData.viewDetailResult);
            $('.menu3' + socketData.surveyId).html(socketData.viewUserAnswer);
            $('.tab-chart' + socketData.surveyId).html(socketData.viewChart);
            $('.tab-detail-result' + socketData.surveyId).html(socketData.viewDetailResult);
            $('.tab-users-answer' + socketData.surveyId).html(socketData.viewUserAnswer);
            paintChart();
        }
    });

    socket.on('delete', function (data) {
        var socketData = $.parseJSON(data);

        if (socketData.success) {
            $('.top-wizard' + socketData.surveyId).css('padding', '25px');
            $('.bot-wizard' + socketData.surveyId).css('padding', '15px');
            $('.container-answer' + socketData.surveyId).remove();
            $('.option-answer' + socketData.surveyId).remove();
            $('.detail-survey' + socketData.surveyId).remove();
            $('.menu-wizard' + socketData.surveyId).remove();
            $('.del-survey' + socketData.surveyId).fadeIn();
            $('.back-home' + socketData.surveyId).fadeIn();
        }
    });

    socket.on('update', function (data) {
        var socketData = $.parseJSON(data);

        if (socketData.success) {
            $('.bot-wizard' + socketData.surveyId).css('padding', '15px');
            $('.option-answer' + socketData.surveyId).remove();
            $('.reload-page' + socketData.surveyId).fadeIn();
        }
    });

    socket.on('invite', function (data) {
        var socketData = $.parseJSON(data);

        if (socketData.success) {
            $.each(socketData.emails, function (index, value) {
                $('.' + value + ' tr:first').after(socketData.viewInvite);
            });
        }
    });

    socket.on('close', function (data) {
        $('.reload-page' + data).fadeIn();
    })
});
