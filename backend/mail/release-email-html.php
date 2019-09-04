<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$link = Yii::$app->urlManager->createAbsoluteUrl(['user/login']);
?>
<div class="password-reset">
	<p>Assalamualaikum w.b.t dan Salam Sejahtera,</p>

	<p>YBhg. Prof. Dato'/Prof. Datuk/Prof./Prof. Madya/Dr./Tuan/Puan,</p>
	
	<p><b>TAWARAN PERLANTIKAN FASILITATOR</b></p>

    <p>Sukacita dimaklumkan bahawa permohonan anda (<?=ucwords(strtolower(Html::encode($name))) ?>) telah diluluskan dan surat tawaran boleh dimuat turun melalui sistem e-Fasi di <a href="https://pusatko.umk.edu.my/user/login">http://pusatko.umk.edu.my/user/login</a>.</p>
	
	<p>Sekiranya anda bersetuju dengan tugas-tugas fasilitator yang disenaraikan dalam lampiran surat tawaran perlantikan, sila klik [Terima] pada halaman permohonan sistem e-Fasi. Seterusnya, sila cetak, tandatangan dan hantar slip penerimaan perlantikan ke pejabat Pusat Ko-kurikulum.</p>

    <p>Sekian dimaklumkan.</p>

    <p>Pusat Ko-Kurikulum<br />
	Universiti Malaysia Kelantan<br />
	Pengkalan Chepa<br />
	16100 Kota Bharu Kelantan.
	</p>
</div>
