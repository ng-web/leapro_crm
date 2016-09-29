<?php

use app\assets\HighChartsAsset;

HighChartsAsset::register($this);
$this->title = 'Highcharts Test';
?>

<h3>Test Chart</h3>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<?php 
$main_data = [];
$xAxisValues = [];
foreach ($rawData as $data) {
    $main_data[] = [
        'data' => $data['bsr_date'], 
        'y' => $data['bs_status'] * 1,
    ];
    $yAxis = $data['bs_status'] * 1;
    $xAxisValues[] = $data['bsr_date'];    
    
    //echo date("m.d.y", strtotime($data['bsr_date'])) . " - " . $xAxis . "<br/>";

}

$main = json_encode($main_data);
$yAxis = json_encode($yAxis);
$xAxis = json_encode($xAxisValues);
//print_r($xAxisValues);
//exit();
?>

<?php $this->registerJs("$(function () {
    $('#container').highcharts({
        chart: {
            type: 'line',
            //margin: 75,
            options3d: {
                enabled: true,
                alpha: 15,
                beta: 15,
                depth: 50
            }
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        title: {
            text: 'Monthly Station Activity',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: $xAxis
        },
        yAxis: {
            title: {
                text: 'Activity'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: 'active'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Station 97 Acitvity',
            data: $main
        }]
    });
});");