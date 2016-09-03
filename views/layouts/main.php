<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Modal;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php Modal::begin([
				'header'=>'<h4></h4>',
				'id'=>'modal',
				'size'=>'modal-lg']);
				echo "<div id='modalContent'></div>";
	  Modal::end();
?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Lepro',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],

        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<script>
  $(function(){
	var i=0;
	 $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
		i++;
		$.post("index.php?r=areas/areas&id="+$("select#companylocations-company_location_id").val(), function( data ) {
					  $( "select#estimatedareas-"+i+"-area_id" ).html( data );
			  });
	});

});

//Keeps track of the indice in the estimate form
$(function(){
    var serivce_index=0;
    var area_index = 0;
    var product_index = 0;

    /*
        Trigger when the an service dynamic field is added.
        Increment the index number and popular the product dropdown;
    */
     $(".service_form_wrappper").on("afterInsert", function(e, item) {
        serivce_index++;
        $("select#productservices-"+serivce_index+"-service_id").change(function(){
             
                  $.post("index.php?r=estimates/find-product-by-service&id="+$(this).val(), function( data ) {
                      $( "select#productsusedperarea-"+serivce_index+"-"+area_index+"-0-product_id" ).html( data );});
          });
                /*
                    Trigger when the an area dynamic field is added.
                    Increment the index number and popular the product dropdown;
                */
                $(".area_form_wrapper").on("afterInsert", function(e, item) {
                    area_index++;
                   $.post("index.php?r=estimates/find-product-by-service&id="+$("select#productservices-"+serivce_index+"-service_id").val(), function( data ) {
                         $( "select#productsusedperarea-"+serivce_index+"-"+area_index+"-0-product_id" ).html( data );
                   });

                   
                   
                }); 

                /*
                    Trigger when the an product dynamic field is added.
                    Increment the index number and popular the product dropdown;
                */
               $(".product_form_wrapper").on("afterInsert", function(e, item) {
                    product_index++;
                    console.log(7);
                       $.post("index.php?r=estimates/find-product-by-service&id="+$("select#productservices-"+serivce_index+"-service_id").val(), function( data ) {
                         $( "select#productsusedperarea-"+serivce_index+"-"+area_index+"-"+product_index+"-product_id" ).html( data );
                   });

                }); 

                    /*
                        Trigger when the a product dynamic field is removed.
                        Reorder the product index number 
                   */
                    $(".product_form_wrapper").on("afterDelete", function(e) {
                        console.log("Deleted item!");
                        product_index--;
                    });
                    
                   /*
                        Trigger when the an area dynamic field is removed.
                        Reorder the area index number 
                    */
                   $(".area_form_wrapper").on("afterDelete", function(e) {
                        console.log("Area Deleted item!");
                        area_index--;
                    });
            /*
                Trigger when the a service dynamic field is removed.
                Reorder the service index number 
            */
             $(".service_form_wrappper").on("afterDelete", function(e) {
                    console.log("Service Deleted item!");
                    service_index--;
              });

    });


});

$(function(){
  $.post("index.php?r=companies/companies&id="+ $("#cust_id").val(), function( data ) {
    $( "select#companies-company_id" ).html(data);
  });
});

$(function(){
   
$('select#companylocations-company_location_id').attr('disabled',true);
	$("select#companies-company_id").change(function () {
		if ($(this).val() > 0) {
			$('select#companylocations-company_location_id').attr('disabled',false);
		}
		else{
			$('select#companylocations-company_location_id').attr('disabled',true);
		}
	});
});


</script>
<?php $this->endPage() ?>
