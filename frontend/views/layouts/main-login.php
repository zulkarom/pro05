<?php

use yii\helpers\Html;
use dmstr\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

frontend\models\LoginAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	
	<style>
	body.external-page #main {
	background : url("<?=$directoryAsset?>/img/jeli.jpg") center center no-repeat fixed;
	background-size:cover;
	}
	.bg-light {
	background-color:#fff;
	}
	.admin-form .panel-footer {
	background-color:#fff;
	border:none;
	}
	

	</style>
</head>
<body class="external-page sb-l-c sb-r-c">
    <!-- Start: Main -->
	<div id="main" class="animated fadeIn login">

		<!-- Start: Content-Wrapper -->
		<section id="content_wrapper">

<?php $this->beginBody() ?>
	<?= Alert::widget() ?>
    <?= $content ?>

<?php $this->endBody() ?>
</section>
</div>
</body>
</html>
<?php $this->endPage() ?>
