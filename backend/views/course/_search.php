<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Component;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\ClaimSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'action' => ['list'],
    'method' => 'get',
	'id' => 'form-filter'
]); ?>
    
	<div class="row">
<div class="col-md-7"><p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Kursus Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p></div>

<div class="col-md-5">
<?= $form->field($model, 'component_id')->label(false)->dropDownList(ArrayHelper::map(Component::find()->all(),'id', 'name'),  ['prompt' => 'Pilih Komponen' ]) ?>
</div>

</div>


<?php ActiveForm::end(); ?>


<?php 


$js = '

$("#coursesearch-component_id").change(function(){
	$("#form-filter").submit();
});

';

$this->registerJs($js);

?>

