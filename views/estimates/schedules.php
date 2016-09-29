<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\EstimateStatus;
use app\models\AdvertisingCampaign;
use yii\web\JsExpression;
use kartik\growl\Growl;
use kartik\dialog\Dialog;

$this->title = 'Scheduler';
$this->params['breadcrumbs'][] = $this->title;

echo Dialog::widget([
   'options' => [], // default options
]);
 
echo Growl::widget([
    'type' => Growl::TYPE_SUCCESS,
    'title' => 'Well done!',
    'icon' => 'glyphicon glyphicon-ok-sign',
    'body' => 'You successfully read this important alert message.',
    'showSeparator' => true,
    'delay' => 0,
    'pluginOptions' => [
        'showProgressbar' => true,
        'placement' => [
            'from' => 'bottom',
            'align' => 'right',
        ]
    ]
]);

$DragJS = <<<EOF
/* initialize the external events
-----------------------------------------------------------------*/
$('#external-events .fc-event').each(function() {
    // store data so the calendar knows to render an event upon drop
    $(this).data('event', {
        title: $.trim($(this).text()), // use the element's text as the event title
        stick: true // maintain when user navigates (see docs on the renderEvent method)
    });
    // make the event draggable using jQuery UI
    $(this).draggable({
        zIndex: 999,
        revert: true,      // will cause the event to go back to its
        revertDuration: 0  //  original position after the drag
    });
});
EOF;
$this->registerJs($DragJS);

$JSDropEvent = <<<EOF
function(date, allDay, jsEvent, ui) {
    
    var compDate = moment(date.format()).add(1,'h');
    $(this).end=compDate.format();
    $(this).allDay = false;
   
    if(date.format("MM-DD-YYYY") >=  moment().format("MM-DD-YYYY")){
         $.post("index.php?r=estimates/set-schedule&id="+$(this).data("id")+"&startDate="+date.format()+"&endDate="+compDate.format(), 
                     function( data ) {
                             
        });
      // if so, remove the element from the "Draggable Events" list
        $(this).remove();
    }
    else{
      
        krajeeDialog.alert("Cannot make schedules in the past");

        
    }
        
}
EOF;

$JSEventMove = <<<EOF
function(event, delta, revertFunc) {
  
   if(event.start.format("MM-DD-YYYY") >= moment().format("MM-DD-YYYY")){
        krajeeDialog.confirm("Are you sure about this change?", function (result) {
            if (result) {
                $.post("index.php?r=estimates/set-schedule&id="+event.id+"&startDate="+event.start.format()+"&endDate="+event.end.format(), function( data ) {
                                 
               });
            } else {
              revertFunc();
            }
        });
    }
     else{
        krajeeDialog.alert("Cannot make schedules in the past");

    }
       
}
EOF;

$JSEditEvent = <<<EOF
function(event, delta, revertFunc) {

   if(event.start.format("MM-DD-YYYY") >= moment().format("MM-DD-YYYY")){
        krajeeDialog.confirm("Are you sure about this change?", function (result) {
            if (result) {
                $.post("index.php?r=estimates/set-schedule&id="+event.id+"&startDate="+event.start.format()+"&endDate="+event.end.format(), function( data ) {
                                 
               });
            } else {
              revertFunc();
            }
        });
   }
     else{
        
        krajeeDialog.alert("Cannot make schedules in the past");

    }
       
}
EOF;
?>



   <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Week Schedules</span>
              <span class="info-box-number"> </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-list-alt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Today Schedules</span>
              <span class="info-box-number"> </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-calendar-check-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Schedule Jobs</span>
              <span class="info-box-number"> <?=count($schedules)?> </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-calendar-times-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Unschedule Jobs</span>
              <span class="info-box-number"><?=count($unschedules)?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
<div class="row">
<div class="col-md-2">
<div id="external-events">
    <center><h4>Unshedule Job Orders</h4></center>
    <?php foreach($unschedules as $unschedule) : ?>
     <div class="fc-event ui-draggable ui-draggable-handle" data-id="<?=$unschedule['estimate_id']?>"
        style="height: 40px; padding: 5px; margin-bottom: 5px;">
        <?=$unschedule['name']?>
    </div>
    <?php endforeach;?>
    
</div>
</div>
<div class="col-md-10">
        <?= yii2fullcalendar\yii2fullcalendar::widget(array(
              
              'clientOptions' => [
                    'defaultView'=> 'agendaWeek',
                    'selectable' => true,
                    'selectHelper' => true,
                    'droppable' => true,
                    'editable' => true,
                    'drop' => new JsExpression($JSDropEvent),
                    'eventResizeStop' => new JsExpression($JSEditEvent),
                    'eventDrop'=> new JsExpression($JSEventMove),
                    'defaultDate' => date('Y-m-d'),
                    'eventConstraint'=>[
                        'start'=> date('Y-m-d'),
                        'end'=> '2100-01-01' // hard coded goodness unfortunately
                   ],

              ],
              'events'=> $schedules,
              //'ajaxEvents' => Url::toRoute(['/site/jsoncalendar'])
            ));
        ?>    
</div></div>    
