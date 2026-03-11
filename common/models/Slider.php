<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;

class Slider extends ActiveRecord
{
    const BUTTON_NONE = 0;
    const BUTTON_COURSE = 1;
    const BUTTON_LOGIN = 2;

    public $imageFile;

    public static function tableName()
    {
        return 'slider';
    }

    public function rules()
    {
        return [
            [['image_path'], 'required'],
            [['button_type', 'sort_order', 'is_active', 'created_at', 'updated_at'], 'integer'],
            [['image_path', 'heading_line1', 'heading_line2', 'heading_line3'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'gif'], 'maxSize' => 5 * 1024 * 1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_path' => 'Image',
            'heading_line1' => 'Heading Line 1',
            'heading_line2' => 'Heading Line 2',
            'heading_line3' => 'Heading Line 3',
            'button_type' => 'Button',
            'sort_order' => 'Sort Order',
            'is_active' => 'Active',
            'imageFile' => 'Upload Image',
        ];
    }

    public function beforeSave($insert)
    {
        $ts = time();
        if ($insert) {
            if ($this->created_at === null) {
                $this->created_at = $ts;
            }
        }
        $this->updated_at = $ts;
        return parent::beforeSave($insert);
    }

    public static function buttonTypeList()
    {
        return [
            self::BUTTON_NONE => 'No button',
            self::BUTTON_COURSE => 'Lihat Senarai Kursus',
            self::BUTTON_LOGIN => 'Sistem e-Fasi',
        ];
    }

    public function getButtonLabel()
    {
        $list = self::buttonTypeList();
        return isset($list[$this->button_type]) ? $list[$this->button_type] : '';
    }

    public function getButtonRoute()
    {
        if ((int)$this->button_type === self::BUTTON_COURSE) {
            return ['site/course'];
        }
        if ((int)$this->button_type === self::BUTTON_LOGIN) {
            return ['user/login'];
        }
        return null;
    }

    public function getButtonUrl()
    {
        $route = $this->getButtonRoute();
        if ($route === null) {
            return null;
        }
        return Url::to($route);
    }

    public function uploadAndSetImagePath($subDir = 'images/slide')
    {
        $file = UploadedFile::getInstance($this, 'imageFile');
        if (!$file) {
            return false;
        }

        $baseDir = Yii::getAlias('@frontend/web/' . $subDir);
        if (!is_dir($baseDir)) {
            if (!@mkdir($baseDir, 0777, true) && !is_dir($baseDir)) {
                return false;
            }
        }

        $name = 'slider_' . uniqid('', true) . '.' . $file->extension;
        $absPath = $baseDir . DIRECTORY_SEPARATOR . $name;
        if (!$file->saveAs($absPath)) {
            return false;
        }

        $this->image_path = '/' . trim($subDir, '/') . '/' . $name;
        return true;
    }
}
