
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
 $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>


   <?= $form->field($model, 'claim_instance')->fileInput() ?>


<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>