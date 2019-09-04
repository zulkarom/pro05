<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\models\Hour;
use common\models\Common;
use yii\widgets\DetailView;
use backend\models\Semester;


/* @var $this yii\web\View */
/* @var $model common\models\Claim */

$this->title = 'BORANG TUNTUTAN';
$this->params['breadcrumbs'][] = ['label' => 'Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="claim-create">

<?php

echo $this->render('_info', [
		'model' => $model
    ]);


$form = ActiveForm::begin(); ?>

<div class="row">
<div class="col-md-12"><div class="box">
<div class="box-header">

<h3 class="box-title">TUNTUTAN BAGI BULAN / TAHUN</h3>

</div>
<div class="box-body"><div class="claim-form">

   <div class="row">


<div class="col-md-4">

<?php 

$sem = Semester::getCurrentSemester();
$months = $sem->getListMonthYearSem();


echo $form->field($model, 'month_year')->dropDownList(
        $months, ['prompt' => 'Sila Pilih']
    )->label('BULAN TAHUN') ?>


</div>
</div>

    
  

</div></div>
</div></div>

</div>




</div>


<div class="form-group">
		
		<?= Html::submitButton('SETERUSNYA <span class="glyphicon glyphicon-arrow-right"></span> ', ['class' => 'btn btn-warning']) ?>
    </div>

<?php ActiveForm::end(); ?>
