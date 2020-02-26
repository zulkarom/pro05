<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model common\models\Claim */

$this->title = 'MAKLUMAT TUNTUTAN BULAN ' . strtoupper($model->monthName()) . ' ' . $model->year;
$this->params['breadcrumbs'][] = ['label' => 'SENARAI TUNTUTAN', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'MAKLUMAT TUNTUTAN';

	?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="application-view">
<style>
table.detail-view th {
    width:25%;
}
</style>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			[
				'attribute' => 'month',
				'value' => function($model){
					return $model->monthName();
				}
			]
			,
			'year',
			[
				'label' => 'Status',
				'format' => 'html',
				'value' => function($m){
					return $m->getWfLabel();
				}
			],
			
			'rate_amount:currency',
			
			[
				'label' => 'Senarai Kelas',
				'format' => 'html',
				'value' => function($m){
					$items = $m->claimItems;
					$str = '';
					if($items){
						foreach($items as $item){
							$str .= date('d M Y', strtotime($item->item_date)) . ' ('.$item->hourStart->hour_format .' - '.$item->hourEnd->hour_format .') - '.$item->sessionType->type_name.'<br />';
						}
					}
					return $str;
				}
			],
			'total_hour',
			[
				'label' => 'Jumlah Tuntutan',
				'format' => 'currency',
				'value' => function($m){
					return $m->total_hour * $m->rate_amount;
				}
			],
			[
				'label' => 'Borang Tuntutan',
				'format' => 'raw',
				'value' => function($m){
					return Html::a('<span class="glyphicon glyphicon-download-alt"></span> BORANG TUNTUTAN', ['claim/claim-print', 'id' => $m->id], ['target' => '_blank'] );
				}
			],
			[
				'label' => 'Kehadiran Dari Portal UMK',
				'format' => 'raw',
				'value' => function($m){
					
					return $m->claimAttendLinks;
				}
			],
			[
				'label' => 'Kehadiran Muat Naik',
				'format' => 'raw',
				'value' => function($m){
					$files = $m->claimFiles;
					$kira = count($files);
					if($files){
						$str = '';
						$i = 1;
						foreach($files as $f){
							$no = $kira > 1 ? $i : '';
							$str .= Html::a(' <span class="glyphicon glyphicon-download-alt"></span> FAIL ' . $no, ['claim/download', 'attr' => 'claim', 'id' => $f->id], ['target' => '_blank'] );
						$i++;
						}
						return $str;
					}
					
				}
			],
			
			[
				'label' => 'Surat Tawaran',
				'format' => 'raw',
				'value' => function($m){
					return Html::a('<span class="glyphicon glyphicon-download-alt"></span> SURAT TAWARAN PERLANTIKAN', ['application/offer-letter', 'id' => $m->application->id], ['target' => '_blank'] );
				}
			],
        ],
    ]) ?>

<i>* Sila <b>muat turun, cetak, tandatangan dan hantar</b> borang tuntutan ke Pejabat Kokurikulum<br />beserta fail kehadiran dan surat tawaran perlantikan fasilitator.</i>

</div>




</div>
</div>
