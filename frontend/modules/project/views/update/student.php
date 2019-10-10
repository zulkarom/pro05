<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\Project */
/* @var $form ActiveForm */

?>

<section class="ftco-services ftco-no-pb">

<div class="container">
<div class="heading-section" align="center">
	<h2 class="mb-4"><span>Kemaskini Kertas Kerja</span> </h2>   
  </div>
  

<?=$this->render('_header', ['model' => $model])?> 


<?=$this->render('_menu', ['token' => $model->pro_token, 'page' => 'student'])?>


 <p>
        <?= Html::a('TAMBAH PELAJAR', ['update/assign', 'token' => $model->pro_token], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
            'student.student_matric',
            'student.student_name',
            'student.program',

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 5%'],
                'template' => '{delete}',
                //'visible' => false,
                'buttons'=>[
                    
					'delete'=>function ($url, $model) {
                        return Html::a('<span class="icon icon-remove"></span>',['update/delete-student/', 'token' => $model->project->pro_token,  'id' => $model->student->id],['class'=>'btn btn-danger btn-sm', 'data' => [
                'confirm' => 'Are you sure to delete this student?'
            ],
]);
                    }
                ],
            
            ],
        ],
    ]); ?>


<br /><br />

</div>

</section>



