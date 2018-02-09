<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "executor_authority".
 *
 * @property int $id
 * @property string $mini_name
 * @property string $name
 * @property string $details
 * @property string $phones
 * @property string $emails
 * @property string $address
 */
class ExecutorAuthority extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'executor_authority';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'details'], 'string'],
            [['mini_name', 'phones', 'emails', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mini_name' => Yii::t('app', 'Mini Name'),
            'name' => Yii::t('app', 'Name'),
            'details' => Yii::t('app', 'Details'),
            'phones' => Yii::t('app', 'Phones'),
            'emails' => Yii::t('app', 'Emails'),
            'address' => Yii::t('app', 'Address'),
        ];
    }

    public function getExecutorsAll()
    {
        return ArrayHelper::map(self::find()->all(), 'name', 'name');
    }
}
