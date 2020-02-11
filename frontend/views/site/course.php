<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="ftco-services ftco-no-pb">
		<div class="container">
		<div class="heading-section">
            <h2 class="mb-4"><span>Senarai Kursus</span> </h2>
			
			
            
          </div>
		  
		
<?=$this->render('_search', ['model' => $searchModel])?>
<style type="text/css">
table.padded-table td { padding:10px; font-size:18px; color:#000000; }
</style>

   <?= GridView::widget([
        'dataProvider' => $dataProvider,
		//'filterModel' => $searchModel,
		'layout' => '{items} {pager}',
		'showHeader'=> false,
		'tableOptions' => [
			'class' => 'padded-table',
		],
        'columns' => [
		
            [
				'value' => function($model, $key, $index){
					return $index + 1 . '. ';
				}
			],
			[
				'attribute' =>'course_code',
				'label' => 'Kod Kursus',
				'format' => 'raw',
				'value' => function($model){
					return ' <a href="#" data-toggle="modal" data-target="#modal-'.$model->id.'">
    '.$model->course_code .'
  </a>';
				}
			]
            ,
            //'authKey',
            // 'accessToken',
            [
				'attribute' =>'course_name',
				'label' => 'Nama Kursus',
				'format' => 'raw',
				'value' => function($model){
				if($model->developmentVersion){
					$syp_bm = $model->developmentVersion->profile->synopsis;
					$syp_bi = $model->developmentVersion->profile->synopsis_bi;
				}else{
					$syp_bm = '';
					$syp_bi = '';
				}
					return '
				
  <a href="#" data-toggle="modal" data-target="#modal-'.$model->id.'">
    '. strtoupper($model->course_name) .'
  </a>

  <!-- The Modal -->
  <div class="modal fade" id="modal-'.$model->id.'">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">'.$model->course_code .'</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" >
		
		<div class="row">
<div class="col-md-8"><h4 class="con-title">Sinopsis Kursus</h4></div>

<div class="col-md-4" align="right" style="font-size:14px">
<a href="javascript:void(0)" class="lnk-bm">BM</a> | <a href="javascript:void(0)" class="lnk-en">EN</a>
</div>

</div>
		
		
		
		<div style="font-size:16px">
		<div class="con-bm">'.$syp_bm .'</div>
		<div class="con-en" style="display:none">'.$syp_bi.'</div>

</div>
        </div>
        
        
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  


					';
					
				}
			],
           

        ],
    ]); ?>

</div>

</section>

<br /><br /><br />


<?php 

$js = '

$("#coursesearch-component_id").change(function(){
	$("#form-filter").submit();
});

$(".lnk-bm").click(function(){
	var body = $(this).parent().parent().parent();
	var bm = body.find(".con-bm");
	var en = body.find(".con-en");
	var title = body.find(".con-title");
	title.text("Sinopsis Kursus");
	bm.show();en.hide();
});

$(".lnk-en").click(function(){
	var body = $(this).parent().parent().parent();
	var bm = body.find(".con-bm");
	var en = body.find(".con-en");
	var title = body.find(".con-title");
	title.text("Course Synopsis");
	en.show();bm.hide();
});



';

$this->registerJs($js);


?>

