<?php 

use yii\helpers\Url;

?>


<ul class="nav nav-tabs">

<?php 

$menu = [

	'utama' => ['UTAMA', ['update/index', 'token' => $token]],
	'student' => ['JAWATANKUASA',['update/committee', 'token' => $token]],
	'tentatif' => ['TENTATIF', ['update/tentative', 'token' => $token]],
	'pendapatan'=> ['PENDAPATAN',['update/income', 'token' => $token]],
	'belanja' => ['PERBELANJAAN',['update/expense', 'token' => $token]],
	'hantar' => ['RINGKASAN DAN HANTAR',['update/preview', 'token' => $token]],

	];
	
	
	foreach($menu as $key => $m){
		$active = $key == $page ? 'active' : '';
		echo '<li class="nav-item">
			<a class="nav-link '.$active.'" href="'.Url::to($m[1]).'">'.$m[0].'</a>
		</li>';
	}


?>

</ul>

<br />