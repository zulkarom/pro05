<?php

use yii\widgets\DetailView;

?>


<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">MAKLUMAT KELULUSAN</h3>

</div>
<div class="box-body">

	
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			'approver.fullname',
			'approve_note',
			'approved_at:datetime',
			
            
            
        ],
    ]) ?>

</div>
</div>