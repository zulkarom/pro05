<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'View Course Information';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-update">


<div class="course-form">

<?=$this->render('_header',[
'course' => $model
])?>


<div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">View Other Version
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
		<?php 
		$versions = $model->versions;
		if($versions){
			foreach($versions as $v){
				echo '<li><a href="'.Url::to(['course/html-view', 'course' => $model->id, 'version' => $v->id]).'" target="_blank">'.$v->version_name .'</a></li>';
			}
		}
		
		?>
  
    
    
	
  </ul>


<?php 

echo $model->reportList('View Doc Report', $version->id)

?>
</div>  <br />

<?=$this->render('_view_course', [
            'model' => $model,
			'version' => $version,
			'current' => true

    ]);
?>




</div>
</div>