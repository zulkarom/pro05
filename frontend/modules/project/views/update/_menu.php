<?php 

use yii\helpers\Url;



?>


<ul class="nav nav-tabs">

<?php 

$menu = [

	'utama' => ['UTAMA', ['update/index', 'token' => $token]],
	'pendapatan'=> ['PENDAPATAN',['update/income', 'token' => $token]],
	'belanja' => ['PERBELANJAAN',['update/expense', 'token' => $token]],
	'tentatif' => ['TENTATIF', ['update/tentative', 'token' => $token]],
	'student' => ['JAWATANKUASA',['update/committee', 'token' => $token]],
	'eft' => ['BORANG EFT',['update/eft', 'token' => $token]],
	'hantar' => ['DOKUMEN DAN HANTAR',['update/preview', 'token' => $token]],

	];
	
	
	foreach($menu as $key => $m){
		$active = $key == $page ? 'active' : '';
		
		if($key == 'belanja'){
			echo '<li class="nav-item dropdown">
			<a class="nav-link '.$active.' dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">'.$m[0].' </a>
			 <div class="dropdown-menu">
			  <a class="dropdown-item" href="'.Url::to($m[1]).'">Asas</a>
			  <a class="dropdown-item" href="'.Url::to(['update/expense-tool', 'token' => $token]).'">Peralatan</a>
			  <a class="dropdown-item" href="'.Url::to(['update/expense-rent', 'token' => $token]).'">Sewaan</a>
			</div>
		  </li>';
		}else if($key == 'student'){
			echo '<li class="nav-item dropdown">
			<a class="nav-link '.$active.' dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">'.$m[0].' </a>
			 <div class="dropdown-menu">
			 
			 <a class="dropdown-item" href="'.Url::to(['update/student', 'token' => $token]).'">Pelajar Terlibat</a>
			 
			  <a class="dropdown-item" href="'.Url::to($m[1]).'">Jawatankuasa Utama</a>
			  
			  <a class="dropdown-item" href="'.Url::to(['update/committee-member', 'token' => $token]).'">Ahli Jawatankuasa</a>
			  
			</div>
		  </li>';
		}else{
			echo '<li class="nav-item">
			<a class="nav-link '.$active.'" href="'.Url::to($m[1]).'">'.$m[0].'</a>
			</li>';
		}
		
		
		
	}


?>

</ul>

<br />