<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $datetime
 * @property string $place
 * @property string $dcreated
 * @property int $bycreated
 *
 * @property User $bycreated0
 * @property MailsIncomingEvents[] $mailsIncomingEvents
 * @property MailsIncoming[] $mailsIncomings
 * @property MailsOutgoingEvents[] $mailsOutgoingEvents
 * @property MailsOutgoing[] $mailsOutgoings
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'datetime', 'dcreated'], 'safe'],
            [['name', 'description', 'place'], 'string', 'max' => 255],
            [['bycreated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['bycreated' => 'id']],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->bycreated = Yii::$app->user->id;
            $this->dcreated = date('Y-m-d H:i:s', time()+2*3600);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'datetime' => Yii::t('app', 'Datetime'),
            'place' => Yii::t('app', 'Place'),
            'dcreated' => Yii::t('app', 'Dcreated'),
            'bycreated' => Yii::t('app', 'Bycreated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBycreated0()
    {
        return $this->hasOne(User::className(), ['id' => 'bycreated']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailsIncomingEvents()
    {
        return $this->hasMany(MailsIncomingEvents::className(), ['events_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailsIncomings()
    {
        return $this->hasMany(MailsIncoming::className(), ['id' => 'mails_incoming_id'])->viaTable('mails_incoming_events', ['events_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailsOutgoingEvents()
    {
        return $this->hasMany(MailsOutgoingEvents::className(), ['events_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailsOutgoings()
    {
        return $this->hasMany(MailsOutgoing::className(), ['id' => 'mails_outgoing_id'])->viaTable('mails_outgoing_events', ['events_id' => 'id']);
    }

    public function getEventsAll()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }
}
