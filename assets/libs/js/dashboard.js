$(document).ready(function() {
    $.ajax({
        url: "controller/dashboard.php",
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            console.log(data);
            $("#card1value").html(data.totalventas+'€');
            $("#card1percentage").html(data.ventasporcentaje);
            $("#sparkline-revenue").sparkline(data.ventas, {
                type: 'line',
                width: '99.5%',
                height: '100',
                lineColor: '#5fa77f',
                fillColor: '#5fa77fAF',
                lineWidth: 2,
                spotColor: undefined,
                minSpotColor: undefined,
                maxSpotColor: undefined,
                highlightSpotColor: undefined,
                highlightLineColor: undefined,
                resize: true
            });
            $("#card2value").html(data.totalpedidos);
            $("#card2percentage").html(data.pedidosporcentaje);
            $("#sparkline-revenue2").sparkline(data.pedidos, {
                type: 'line',
                width: '99.5%',
                height: '100',
                lineColor: '#476c5e',
                fillColor: '#476c5eAF',
                lineWidth: 2,
                spotColor: undefined,
                minSpotColor: undefined,
                maxSpotColor: undefined,
                highlightSpotColor: undefined,
                highlightLineColor: undefined,
                resize: true
            });
            $("#card3value").html(data.totalmedio+'€');
            $("#card3percentage").html(data.medioporcentaje);
            $("#sparkline-revenue3").sparkline(data.ticketmedio, {
                type: 'line',
                width: '99.5%',
                height: '100',
                lineColor: '#f2cd5e',
                fillColor: '#f2cd5eAF',
                lineWidth: 2,
                spotColor: undefined,
                minSpotColor: undefined,
                maxSpotColor: undefined,
                highlightSpotColor: undefined,
                highlightLineColor: undefined,
                resize: true
            });
            $("#card4value").html(data.totalusers);
            $("#card4percentage").html(data.usersporcentaje);
            $("#sparkline-revenue4").sparkline(data.users, {
                type: 'line',
                width: '99.5%',
                height: '100',
                lineColor: '#f2ab27',
                fillColor: '#f2ab27AF',
                lineWidth: 2,
                spotColor: undefined,
                minSpotColor: undefined,
                maxSpotColor: undefined,
                highlightSpotColor: undefined,
                highlightLineColor: undefined,
                resize: true,
            });
            // ============================================================== 
            // Customer acquisition
            // ============================================================== 
            var chart = new Chartist.Line('.ct-chart', {
                labels: data.days, //['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'],
                series: [
                    data.registeredorders,
                    data.nonregisteredorders

                ]
            }, {
                low: 0,
                showArea: true,
                showPoint: false,
                fullWidth: true
            });

            chart.on('draw', function(data) {
                if (data.type === 'line' || data.type === 'area') {
                    data.element.animate({
                        d: {
                            begin: 2000 * data.index,
                            dur: 2000,
                            from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                            to: data.path.clone().stringify(),
                            easing: Chartist.Svg.Easing.easeOutQuint
                        }
                    });
                }
            });

             // ============================================================== 
            // Product Category
            // ============================================================== 
            var chart = new Chartist.Pie('.ct-chart-category', {
                series: data.categoryorders,//[60, 90, 30],
                labels: data.categoryorders//['Bananas', 'Apples', 'Grapes']
            }, {
                donut: true,
                showLabel: true,
                donutWidth: 40

            });


            chart.on('draw', function(data) {
                if (data.type === 'slice') {
                    // Get the total path length in order to use for dash array animation
                    var pathLength = data.element._node.getTotalLength();

                    // Set a dasharray that matches the path length as prerequisite to animate dashoffset
                    data.element.attr({
                        'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
                    });

                    // Create animation definition while also assigning an ID to the animation for later sync usage
                    var animationDefinition = {
                        'stroke-dashoffset': {
                            id: 'anim' + data.index,
                            dur: 1000,
                            from: -pathLength + 'px',
                            to: '0px',
                            easing: Chartist.Svg.Easing.easeOutQuint,
                            // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
                            fill: 'freeze'
                        }
                    };

                    // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
                    if (data.index !== 0) {
                        animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
                    }

                    // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us
                    data.element.attr({
                        'stroke-dashoffset': -pathLength + 'px'
                    });

                    // We can't use guided mode as the animations need to rely on setting begin manually
                    // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
                    data.element.animate(animationDefinition, false);
                }
            });

                // ============================================================== 
                // Total Revenue
                // ============================================================== 
                 console.log(data.totalpermonth); 
                Morris.Area({
                    
                    element: 'morris_totalrevenue',
                    behaveLikeLine: true,
                    data: data.totalpermonth
                        /* { x: 'Ene', y: 0, },
                        { x: 'Feb', y: 7500, },
                        { x: 'Mar', y: 5000, },
                        { x: 'Abr', y: 22500, } */
                    ,
                    parseTime: false,
                    xkey: 'x',
                    ykeys: ['y'],
                    labels: ['Ventas'],
                    lineColors: ['#5fa77f'],
                    resize: true

                });


        },
        error: function(data) {
        }
    });

           
});