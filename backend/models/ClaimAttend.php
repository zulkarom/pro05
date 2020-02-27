<?php

namespace backend\models;

use Yii;
use common\models\Claim;

/**
 * This is the model class for table "claim_attend".
 *
 * @property int $id
 * @property int $claim_id
 * @property string $portal_id
 * @property string $updated_at
 */
class ClaimAttend extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'claim_attend';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['claim_id', 'portal_id', 'updated_at'], 'required'],
            [['claim_id'], 'integer'],
            [['updated_at'], 'safe'],
            [['portal_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'claim_id' => 'Claim ID',
            'portal_id' => 'Portal ID',
            'updated_at' => 'Updated At',
        ];
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
	
	public function getClaim()
    {
        return $this->hasOne(Claim::className(), ['id' => 'claim_id']);
    }


}
