<?php 

use yii\helpers\Url;

?>

<section class="ftco-services ftco-no-pb">

<div class="container">
<div class="heading-section" align="center">
	<h2 class="mb-4"><span>Kertas Kerja</span> </h2>   
  </div>
		  

<div class="row">
<div class="col-md-4"></div>

<div class="col-md-4">

<div class="form-group">

<div align="center" style="font-size:25px;font-weight:bold">KATA KUNCI</div>
<input id="token" class="form-control" name="token" style="text-align:center;font-family:courier;font-weight:bold;text-transform:uppercase" />


</div>

<div class="form-group" align="center">

<button id="submit" type="button" class="btn btn-primary">HANTAR</button>


</div>

</div>

</div>



</div>

</section>
<br /><br /><br /><br /><br /><br />
<?php
$js = "

function submit(){
	var token = $('#token').val();
	if(token){
		window.location.href = '" . Url::to(['/project/update','token' => '']) . "' + token;
	}else{
		alert('Sila Isi Kata Kunci');
	}
}

$('#submit').click(function(e, data){
    submit();
});

$('#token').on('keypress',function(e) {
    if(e.which == 13) {
        submit();
    }
});



";

$this->registerJs($js);

?>



