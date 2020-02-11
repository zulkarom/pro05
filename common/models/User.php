<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use backend\modules\staff\models\Staff;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
	
	
	public $rawPassword;
	public $password_repeat;
	public $oldPassword;
	public $newPassword;
	public $upload_image;
	

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
			
			[['username', 'fullname', 'email'], 'required', 'on' => 'signup'],
			
			
			
			[['username', 'password', 'rawPassword', 'password_repeat', 'fullname', 'email'], 'required', 'on' => 'create'],
			
			[['username', 'password', 'rawPassword', 'password_repeat', 'fullname', 'email'], 'required', 'on' => 'create'],
			
			[['username', 'fullname', 'email'], 'required', 'on' => 'update'],
			
			
			
			[['upload_image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
			
			[['oldPassword', 'rawPassword', 'password_repeat'], 'required', 'on' => 'change_password'],
			
			['email', 'email'],
			
			//['username', 'match', 'pattern' => '/\D/'],
			
			//['username', 'match', 'pattern' => '/^(?=.{4})(?!.{21})[\w.-]*[a-z][\w-.]*$/i'],
			
			['password_repeat', 'compare', 'compareAttribute' => 'rawPassword', 'on' => 'create'],
			
			['password_repeat', 'compare', 'compareAttribute' => 'newPassword', 'on' => 'change_password' ],
			
			
			['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken'],
			
			[['username'], 'string', 'max' => 32],
			//[['user_image'], 'string', 'max' => 200],
            [['rawPassword'], 'string', 'min' => 6],
			[['username'], 'string', 'min' => 5],
        ];
    }
	
	public function attributeLabels()
    {
        return [
            'rawPassword' => 'Password',
            'email' => 'Email',
			'fullname' => 'Nama Penuh',
			'username' => 'NRIC',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
	
	public function getFasi(){
		return $this->hasOne(Fasi::className(), ['user_id' => 'id']);
	}
	
	public function getStaff(){
		return $this->hasOne(Staff::className(), ['user_id' => 'id']);
	}

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
	
	public function getPassword()
    {
		//return '';
        return $this->password_hash;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
	
	public static function listFullnameArray(){
		$users = self::find()->all();
		$array = [];
		foreach($users as $user){
			$array[$user->id] = ucwords(strtolower($user->fullname));
		}
		
		return $array;
	}

}
