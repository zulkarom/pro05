<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var yii\web\View $this
 * @var dektrium\user\Module $module
 */
use yii\helpers\Url;
$this->title = $title;
?>

<?= $this->render('/_alert', ['module' => $module])?>


<div style="background-color:#ffffff;padding:10px;font-weight:bold;font-size:16px; text-align:center"><a href="<?=Url::to(['/user/login'])?>">HALAMAN LOG MASUK<a></div>