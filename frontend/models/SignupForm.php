<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\models\Fasi;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
	public $fullname;
    public $user_email;
    public $rawPassword;
	public $password_repeat;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		
			['fullname', 'required'],
			
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
			
            ['username', 'string', 'min' => 12, 'max' => 12],
			['username', 'number'],

            ['user_email', 'trim'],
            ['user_email', 'required'],
            ['user_email', 'email'],
            ['user_email', 'string', 'max' => 255],
			
            ['user_email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['rawPassword', 'required'],
            ['rawPassword', 'string', 'min' => 6],
			
			['password_repeat', 'required'],
            ['password_repeat', 'string', 'min' => 6],
			 ['password_repeat', 'compare', 'compareAttribute'=>'rawPassword', 'message'=>"ULANGAN KATA LALUAN TIDAK SAMA" ],
        ];
    }
	
	public function attributeLabels()
    {
        return [
			'fullname' => 'NAMA PENUH',
            'password' => 'KATA LALUAN',
			'password_repeat' => 'ULANG KATA LALUAN',
            'user_email' => 'EMAIL',
			'username' => 'NO KAD PENGENALAN',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
		$fasi = new Fasi;
		
        $user->username = $this->username;
		 $user->fullname = $this->fullname;
        $user->user_email = $this->user_email;
        $user->setPassword($this->rawPassword);
        $user->generateAuthKey();
		
		///auto activate for now
		$user->user_active = 1;
		
		$user->scenario = "signup";
		
		$user_save = $user->save();
		
		$fasi->scenario = "signup";
		$fasi->user_id = $user->id;
		$fasi->nric = $this->username;
		$fasi->save(); 
		

        return $user_save and $fasi->save() ? $user : null;
    }
}
