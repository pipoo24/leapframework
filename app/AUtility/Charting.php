<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/17/15
 * Time: 9:21 AM
 */

class Charting {

    //for donut and pie
    var $color; //if color is inserted will overide all colors for line charts
    var $value;
    var $label;
    var $highlight;

    //for line charts
    var $fillColor = "rgba(210, 214, 222, 1)";
    var $strokeColor = "rgba(210, 214, 222, 1)";
    var $pointColor = "rgba(210, 214, 222, 1)";
    var $pointStrokeColor = "#c1c7d1";
    var $pointHighlightStroke = "rgba(220,220,220,1)";
    var $data;


    //$arrData consist of colors, label, value
    public static function morrisDonut($height,$arrData){

        $id = "donut_".time().rand(1,500);

        foreach($arrData as $obj){
            $colors[] = '"'.$obj->color.'"';
            $labels[] = '{label: "'.$obj->label.'", value: '.$obj->value.'}';
        }

        //parse color
        $impColors = implode(",",$colors);
        $impData = implode(",",$labels);

        ?>
        <div class="chart" id="<?=$id;?>" style="height: <?=$height;?>; position: relative;"></div>
        <script>
            setTimeout(function(){
                //DONUT CHART
                var donut = new Morris.Donut({
                    element: '<?=$id;?>',
                    resize: true,
                    colors: [<?=$impColors;?>],
                    data: [
                        <?=$impData;?>
                    ],
                    hideHover: 'auto'
                });
            }, 100);
        </script>
        <?
    }

    //morris Bar
    public static function chartJSPie($height,$arrData,$cutout=0){

        $id = "pie_".time().rand(1,500);

        foreach($arrData as $obj){
            if($obj->highlight == "")$obj->highlight = $obj->color;
            $labels[] = '{label: "'.$obj->label.'", value: '.$obj->value.', color: "'.$obj->color.'",highlight: "'.$obj->highlight.'" }';
        }
        $impData = implode(",",$labels);
        ?>
        <div class="chart">
            <canvas id="<?=$id;?>" style="height:<?=$height;?>;"></canvas>
        </div>
    <script>
        setTimeout(function(){
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $("#<?=$id;?>").get(0).getContext("2d");
            var pieChart = new Chart(pieChartCanvas);
            var PieData = [
                <?=$impData;?>
            ];
            var pieOptions = {
                //Boolean - Whether we should show a stroke on each segment
                segmentShowStroke : true,

                //String - The colour of each segment stroke
                segmentStrokeColor : "#fff",

                //Number - The width of each segment stroke
                segmentStrokeWidth : 3,

                //Number - The percentage of the chart that we cut out of the middle
                percentageInnerCutout : <?=$cutout;?>, // This is 0 for Pie charts

                //Number - Amount of animation steps
                animationSteps : 100,

                //String - Animation easing effect
                animationEasing : "easeOutBounce",

                //Boolean - Whether we animate the rotation of the Doughnut
                animateRotate : true,

                //Boolean - Whether we animate scaling the Doughnut from the centre
                animateScale : true,

                //String - A legend template
                legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"

            };
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            pieChart.Pie(PieData, pieOptions);
        }, 100);
    </script>
        <?
    }

    public static function chartJSLine($height,$xLabels,$arrData,$dataSetFill = "true",$showLegend = 1){

        $id = "line_".time().rand(1,500);

        $arrSS = array();
        foreach($xLabels as $l){
            $arrSS[] = '"'.$l.'"';
        }
        $impLabels = implode(",",$arrSS);

        $arrDataSet = array();
        foreach($arrData as $obj){
            $impdata = implode(",",$obj->data);

            //override using color
            if($obj->color != ""){
                $obj->fillColor = $obj->color;
                $obj->strokeColor = $obj->color;
                $obj->pointColor =  $obj->color;
            }

            $arrDataSet[] = '{
                            label: "'.$obj->label.'",
                            fillColor: "'.$obj->fillColor.'",
                            strokeColor: "'.$obj->strokeColor.'",
                            pointColor: "'.$obj->pointColor.'",
                            pointStrokeColor: "'.$obj->pointStrokeColor.'",
                            pointHighlightFill: "'.$obj->pointHighlightFill.'",
                            pointHighlightStroke: "'.$obj->pointHighlightStroke.'",
                            data: ['.$impdata.']
                        }';
        }
        $impDataset = implode(",",$arrDataSet);

        ?>
        <div class="chart">
            <canvas id="<?=$id;?>" style="height:<?=$height;?>"></canvas>
            <div id="<?=$id;?>_legend">sssss</div>
        </div>
        <script>
            setTimeout(function(){
                // Get context with jQuery - using jQuery's .get() method.
                var areaChartCanvas = $("#<?=$id;?>").get(0).getContext("2d");
                // This will get the first returned node in the jQuery collection.
                var areaChart = new Chart(areaChartCanvas);

                var areaChartData = {
                    labels: [<?=$impLabels;?>],
                    datasets: [
                        <?=$impDataset;?>
                    ]
                };

                var areaChartOptions = {
                    //Boolean - If we should show the scale at all
                    showScale: true,
                    //Boolean - Whether grid lines are shown across the chart
                    scaleShowGridLines: true,
                    //String - Colour of the grid lines
                    scaleGridLineColor: "rgba(0,0,0,.05)",
                    //Number - Width of the grid lines
                    scaleGridLineWidth: 1,
                    //Boolean - Whether to show horizontal lines (except X axis)
                    scaleShowHorizontalLines: true,
                    //Boolean - Whether to show vertical lines (except Y axis)
                    scaleShowVerticalLines: true,
                    //Boolean - Whether the line is curved between points
                    bezierCurve: true,
                    //Number - Tension of the bezier curve between points
                    bezierCurveTension: 0.3,
                    //Boolean - Whether to show a dot for each point
                    pointDot: true,
                    //Number - Radius of each point dot in pixels
                    pointDotRadius: 3,
                    //Number - Pixel width of point dot stroke
                    pointDotStrokeWidth: 1,
                    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                    pointHitDetectionRadius: 20,
                    //Boolean - Whether to show a stroke for datasets
                    datasetStroke: true,
                    //Number - Pixel width of dataset stroke
                    datasetStrokeWidth: 2,
                    //Boolean - Whether to fill the dataset with a color
                    datasetFill: <?=$dataSetFill;?>,
                    //String - A legend template
                    legendTemplate: " <% for (var i=0; i<datasets.length; i++){%><div class=\"legend-item\"><div style=\"width:10px; height:10px;background-color:<%=datasets[i].pointColor%>;\"></div><%if(datasets[i].label){%><%=datasets[i].label%><%}%></div><%}%>",
                    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                    maintainAspectRatio: true,
                    //Boolean - whether to make the chart responsive to window resizing
                    responsive: true,
                    multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
                };

                //Create the line chart
                var myChart = areaChart.Line(areaChartData, areaChartOptions);



                <? if($showLegend){?>
                //and append it to your page somewhere
                document.getElementById('<?=$id;?>_legend').innerHTML = myChart.generateLegend();

                <? } ?>

            }, 100);
        </script>
        <?
    }

    public static function chartJSBar($height,$xLabels,$arrData,$dataSetFill = "false",$showLegend = 0){
        $id = "bar_".time().rand(1,500);


        $arrSS = array();
        foreach($xLabels as $l){
            $arrSS[] = '"'.$l.'"';
        }
        $impLabels = implode(",",$arrSS);

        $arrDataSet = array();
        foreach($arrData as $obj){
            $impdata = implode(",",$obj->data);

            //override using color
            if($obj->color != ""){
                $obj->fillColor = $obj->color;
                $obj->strokeColor = $obj->color;
                $obj->pointColor =  $obj->color;
            }

            $arrDataSet[] = '{
                            label: "'.$obj->label.'",
                            fillColor: "'.$obj->fillColor.'",
                            strokeColor: "'.$obj->strokeColor.'",
                            pointColor: "'.$obj->pointColor.'",
                            pointStrokeColor: "'.$obj->pointStrokeColor.'",
                            pointHighlightFill: "'.$obj->pointHighlightFill.'",
                            pointHighlightStroke: "'.$obj->pointHighlightStroke.'",
                            data: ['.$impdata.']
                        }';
        }
        $impDataset = implode(",",$arrDataSet);
        ?>
        <div class="chart">
            <canvas id="<?=$id;?>" style="height:<?=$height;?>"></canvas>
            <div id="<?=$id;?>_legend"></div>
        </div>
        <script>
            setTimeout(function(){

                var areaChartData = {
                    labels: [<?=$impLabels;?>],
                    datasets: [
                        <?=$impDataset;?>
                    ]
                };
                //-------------
                //- BAR CHART -
                //-------------
                var barChartCanvas = $("#<?=$id;?>").get(0).getContext("2d");
                var barChart = new Chart(barChartCanvas);
                var barChartData = areaChartData;
//                barChartData.datasets[1].fillColor = "#00a65a";
//                barChartData.datasets[1].strokeColor = "#00a65a";
//                barChartData.datasets[1].pointColor = "#00a65a";
                var barChartOptions = {
                    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                    scaleBeginAtZero: true,
                    //Boolean - Whether grid lines are shown across the chart
                    scaleShowGridLines: true,
                    //String - Colour of the grid lines
                    scaleGridLineColor: "rgba(0,0,0,.05)",
                    //Number - Width of the grid lines
                    scaleGridLineWidth: 1,
                    //Boolean - Whether to show horizontal lines (except X axis)
                    scaleShowHorizontalLines: true,
                    //Boolean - Whether to show vertical lines (except Y axis)
                    scaleShowVerticalLines: true,
                    //Boolean - If there is a stroke on each bar
                    barShowStroke: true,
                    //Number - Pixel width of the bar stroke
                    barStrokeWidth: 2,
                    //Number - Spacing between each of the X value sets
                    barValueSpacing: 5,
                    //Number - Spacing between data sets within X values
                    barDatasetSpacing: 1,
                    //String - A legend template
//                    legendTemplate: "<ul class=\"<%//=name.toLowerCase()%>//-legend\"><%// for (var i=0; i<datasets.length; i++){%>//<li><span style=\"background-color:<%//=datasets[i].fillColor%>//\"></span><%//if(datasets[i].label){%><!----><%//=datasets[i].label%><!----><%//}%>//</li><%//}%>//</ul>",
                    //String - A legend template
                    legendTemplate: " <% for (var i=0; i<datasets.length; i++){%><div class=\"legend-item\"><div style=\"width:10px; height:10px;background-color:<%=datasets[i].fillColor%>;\"></div><%if(datasets[i].label){%><%=datasets[i].label%><%}%></div><%}%>",

                    //Boolean - whether to make the chart responsive
                    responsive: true,
                    maintainAspectRatio: true,
                    multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
                };

                barChartOptions.datasetFill = <?=$dataSetFill;?>;
                var myChart = barChart.Bar(barChartData, barChartOptions);



                <? if($showLegend){?>
                //and append it to your page somewhere
                document.getElementById('<?=$id;?>_legend').innerHTML = myChart.generateLegend();

                <? } ?>

            }, 100);
        </script>


        <?
    }
} 