<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use backend\models\Component;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\ClaimSearch */
/* @var $form yii\widgets\ActiveForm */

$get = Yii::$app->request->get();
$component = Component::find()->all();
$options = '';
foreach($component as $c){
	$selected = '';
	if(isset($get['CourseSearch'])){
		$get_com = $get['CourseSearch'];
		//echo 'xxx' . $get_com['component_id'];
		$selected = $c->id == $get_com['component_id'] ? 'selected' : '';
	}
	
	$options .= '<option value="'.$c->id .'" '.$selected.'>'.$c->name .'</option>';
}
if(isset($get['CourseSearch'])){
	
}
?>

<form id="form-filter" class="form-vertical" action="<?=Url::to(['site/course'])?>" method="get" role="form">    
	<div class="row">

<div class="col-md-5">
<div class="form-group field-coursesearch-component_id has-success">


<select id="coursesearch-component_id" class="form-control" name="CourseSearch[component_id]" aria-invalid="false">
<option value="">Pilih Komponen</option>
<?=$options?>
</select>

<div class="help-block"></div>

</div></div>

</div>


</form>


<?php 


$js = '

$("#coursesearch-component_id").change(function(){
	$("#form-filter").submit();
});



';

$this->registerJs($js);

?>