<?php
namespace common\widgets;

use Yii;

class MyAlert
{
    public $closeButton = [];

    /**
     * {@inheritdoc}
     */
    public static function show()
    {
		$alertTypes = [
        'error'   => 'alert-danger',
        'danger'  => 'alert-danger',
        'success' => 'alert-success',
        'info'    => 'alert-info',
        'warning' => 'alert-warning'
		];
		
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
		
        foreach ($flashes as $type => $flash) {
            if (!isset($alertTypes[$type])) {
                continue;
            }

            foreach ((array) $flash as $i => $message) {
				echo '<div class="alert '. $alertTypes[$type].' alert-dismissible show" role="alert">
				  '.$message.'
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>';
            }

            $session->removeFlash($type);
        }
    }
}
