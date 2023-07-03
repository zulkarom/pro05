<?php

namespace frontend\models;

use Yii;
use backend\models\Service;
use common\models\User;

/**
 * This is the model class for table "supplier_provide".
 *
 * @property int $id
 * @property int $supplier_id
 * @property int $service_id
 */
class SupplierProvide extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier_provide';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'service_id'], 'required'],
            [['supplier_id', 'service_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => 'Supplier ID',
            'service_id' => 'Service',
        ];
    }
	
	
	
	//maybe there is better way to do this
	public function getServiceName(){
		$service = new Service;
		return $service->findOne(['id' => $this->service_id])->service_name;
	}
	
	public function getService(){
		return $this->hasOne(Service::className(), ['id' => 'service_id']);
	}
	
	
	public function getUser(){
		return $this->hasOne(User::className(), ['id' => 'supplier_id']);
	}
	

}
