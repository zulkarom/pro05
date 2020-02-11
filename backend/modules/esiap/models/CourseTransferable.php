<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course_transfer".
 *
 * @property int $id
 * @property int $crs_version_id
 * @property int $transferable_id
 */
class CourseTransferable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sp_course_transfer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transferable_id'], 'required'],
            [['crs_version_id', 'transferable_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'crs_version_id' => 'Crs Version ID',
            'transferable_id' => 'Transferable Skill',
        ];
    }
	
	public function getTransferable(){
         return $this->hasOne(Transferable::className(), ['id' => 'transferable_id']);
    }
	
	public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }

    }


}
