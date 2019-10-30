<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\project\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'KEMASKINI KERTAS KERJA';
$this->params['breadcrumbs'][] = $this->title;
use kartik\date\DatePicker;
?>

<?php $form = ActiveForm::begin(); ?>

  <div class="box">
<div class="box-header"></div>
<div class="box-body">  

<div class="row">
<div class="col-md-8">

<?= $form->field($model, 'pro_name')->textarea(['rows' => 2]) ?>

<?= $form->field($model, 'location')->textInput() ?>

<div class="row">
<div class="col-md-4">

<?php 

$kira = count($days);

if($kira == 1){
	echo Html::activeHiddenInput($days[0], "[0]id");
	echo $form->field($days[0], '[0]pro_date')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ]])->label('Tarikh');

}else if($kira > 1){
	
	foreach($days as $i => $day){
		$ke = $i +1;
		echo Html::activeHiddenInput($day, "[{$i}]id");
		echo $form->field($day, "[{$i}]pro_date")->widget(DatePicker::classname(), [
		'removeButton' => false,
		'pluginOptions' => [
			'autoclose'=>true,
			'format' => 'yyyy-mm-dd',
			'todayHighlight' => true,
			
		]])->label('Tarikh ' . $ke);
	}
	
}

?>
</div>

</div>



<?= $form->field($model, 'purpose')->textarea(['rows' => 2]) ?>

<?= $form->field($model, 'background')->textarea(['rows' => 2]) ?>

<?= $form->field($model, 'eft_name')->textInput() ?>

</div>

</div>



	
	
	
<div class="form-group">
        
<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div></div>
</div>


    <?php ActiveForm::end(); ?>
