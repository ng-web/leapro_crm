<?=$this->title = ''?>
<?= \dosamigos\highcharts\HighCharts::widget([
    'clientOptions' => [
        'chart' => [
                'type' => 'line'
        ],
        'title' => [
             'text' => 'Summary for current year'
             ],
        'xAxis' => [
            'categories' => [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December',
            ]
        ],
        'yAxis' => [
            'title' => [
                'text' => ''
            ]
        ],
        'series' => [
            ['name' => 'JobOrders', 'data' => $jobOrders],
            ['name' => 'Declined Estimates', 'data' => $declined]
        ]
    ]
]);
?>