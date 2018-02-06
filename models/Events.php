<?php

namespace app\models;

use Yii;

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
            [['datetime', 'dcreated'], 'safe'],
            [['bycreated'], 'integer'],
            [['name', 'description', 'place'], 'string', 'max' => 255],
            [['bycreated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['bycreated' => 'id']],
        ];
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
}
