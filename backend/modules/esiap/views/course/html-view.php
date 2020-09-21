<?php 
$this->title = $model->course_code . ' ' . $model->course_name;


?>
<h3>SUMMARY OF COURSE INFORMATION</h3>
<?=$this->render('_view_course', [
            'model' => $model,
			'version' => $version,
			'current' => false

    ]);
?>

