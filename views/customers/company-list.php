
<?php use kartik\grid\GridView;?>

<?= 
GridView::widget([
    'dataProvider'=>$companiesDataProvider,
    'showPageSummary'=>true,
    'pjax'=>true,
    'hover'=>true,
    'panel'=>['type'=>'primary', 'heading'=>'Companies'],
    'columns'=>[
        [
            'attribute'=>'company_name', 
            'width'=>'310px',
            'value'=>function ($model, $key, $index, $widget) { 
                return $model['company_name'];
            },
             'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any Company'],
            'group'=>true,  // enable grouping,
            'groupedRow'=>true,                    // move grouped column to a single grouped row
            'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
        ],
        [
            'attribute'=>'location', 
            'width'=>'250px',
            'value'=>function ($model, $key, $index, $widget) { 
                return $model['address_line1'].', '.$model['address_line2'].' '.$model['address_province'];
            },
           'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any Location'],
            'group'=>true,  // enable grouping
            'subGroupOf'=>1,// supplier column index is the parent group
            'groupedRow'=>true, 
        ],
    ],
]);
 ?>