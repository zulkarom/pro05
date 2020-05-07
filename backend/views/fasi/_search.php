<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Campus;

/* @var $this yii\web\View */
/* @var $model backend\models\FasiSearch */
/* @var $form yii\widgets\ActiveForm */
?>


  <?php $form = ActiveForm::begin([
    'action' => ['/fasi/active-fasi'],
	'id' => 'form-search',
    'method' => 'get',
]); ?>
    
<div class="row">
<div class="col-md-8"></div>
<div class="col-md-4">
<?= $form->field($model, 'campus')->label(false)->dropDownList(
        ArrayHelper::map(Campus::find()->all(),'id', 'campus_name'), ['prompt' => 'Overall' ]
    ) 
 ?>


</div>
</div>

<?php ActiveForm::end(); 


$this->registerJs('



$("#fasiactivesearch-campus").change(function(){
	
	$("#form-search").submit();
	
});

');


?>