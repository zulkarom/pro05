<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Upload;
 ?>


<div class="box">
<div class="box-header">

<h3 class="box-title"><i class="fa fa-asterisk"></i> BAHAGIAN B</h3>

</div>
<div class="box-body"><div class="claim-form">


    <table class="table table-bordered table-striped">
        <thead>
            <tr>
				<th>#</th>
                <th>Tarikh</th>
				<th width="15%">Masa</th>
				<th width="25%">Jenis Sesi</th>
				<th>Pengiraan</th>
				<th>Jumlah</th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php 
		$i = 1;
		$rate = $model->application->rate_amount;
		$total = 0;
		foreach ($items as $item): ?>
            <tr class="claim-item">
				<td><?=$i?></td>
			
                <td class="vcenter">
                    <?=date('d M Y', strtotime($item->item_date))?>
                </td>
				
				<td class="vcenter">
					<?=$item->hourStart->hour_format?> - <?=$item->hourEnd->hour_format?>
                </td>

				
				<td class="vcenter">
                   <?=$item->sessionType->type_name?> 
                </td>
				<td><?php 
				
				$duration = $item->hour_end - $item->hour_start;
				$duration = $duration > 0 ? $duration : 0;
				echo $duration . ' x RM' . $rate;
				$total += ($duration * $rate);
				?></td>
				<td><?='RM' . number_format($duration * $rate,0) ?></td>

 
            </tr>
         <?php $i++; endforeach; ?>
        </tbody>
		
		<tfoot>
            <tr>
			<td></td>
                <td colspan="4">
	
				
				</td>
                <td><?='RM' . $total?></td>

            </tr>
        </tfoot>
		
    </table>


</div></div>
</div>


<div class="row">
<div class="col-md-6"><div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">FAIL KEHADIRAN</h3>

</div>
<div class="box-body">

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tbody>
      <tr>
        <td>Portal UMK</td>
        <td>
		<?php 
		echo file_get_contents('https://portal.umk.edu.my/api/timetable/list?semester=201920201&subject=APT2043&group=L4');
		//echo $model->claimAttendLinks;
		?>
		</td>
      </tr>
      <tr>
        <td>Muat Naik</td>
        <td>
		<?php 
if($model->claimFiles){
	foreach($model->claimFiles as $file){
		echo Upload::showFile($file, 'claim', 'claim') .' ';
	}
} 

?>
		
		</td>
      </tr>
    </tbody>
  </table>
</div>




</div>
</div></div>
<div class="col-md-6"><div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">BORANG TUNTUTAN</h3>

</div>
<div class="box-body">
<a href="<?=Url::to(['claim/claim-print', 'id' => $model->id])?>" target="_blank"><span class="glyphicon glyphicon-download-alt"></span> MUAT TURUN BORANG TUNTUTAN</a>
<br /><br />
</div>
</div></div>
</div>

