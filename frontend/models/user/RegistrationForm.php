<?php
namespace frontend\models\user;

//use dektrium\user\models\User;
use Yii;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use common\models\Fasi;

/**
 * Signup form
 */
class RegistrationForm extends BaseRegistrationForm
{
	public $fullname;
	public $password_repeat;
	
	public function rules()
    {
        $rules = parent::rules();
		
		$rules['usernameLength']  = ['username', 'number', 'message' => '{attribute} mestilah dalam bentuk nombor tanpa "-"'];
		
        $rules['fullnameRequired'] = ['fullname', 'required'];
		$rules['password_repeatRequired'] = ['password_repeat', 'required'];
        $rules['fullnameLength']   =  ['fullname', 'string', 'min' => 3, 'max' => 255];
		
		$rules['password_repeatCompare'] = ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ];
		

		//
        return $rules;
    }
	
	public function attributeLabels()
    {
		$label = parent::attributeLabels();
		$label['username'] = 'No. Kad Pengenalan';
		$label['fullname'] = 'Nama Penuh';
		$label['password'] = 'Kata Laluan';
		$label['password_repeat'] = 'Ulang Kata Laluan';
        return $label;
    }
	
	public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);

        if (!$user->register()) {
            return false;
        }
		
		$fasi = new Fasi;
		$fasi->scenario = "signup";
		$fasi->user_id = $user->id;
		$fasi->nric = $user->username;
		$fasi->year_register = date('Y');
		$fasi->save(); 
		

        Yii::$app->session->setFlash(
            'info',
            Yii::t(
                'user',
                'Your account has been created and a message with further instructions has been sent to your email'
            )
        );

        return true;
    }


}
