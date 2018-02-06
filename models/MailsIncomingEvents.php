<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mails_incoming_events".
 *
 * @property int $mails_incoming_id
 * @property int $events_id
 *
 * @property Events $events
 * @property MailsIncoming $mailsIncoming
 */
class MailsIncomingEvents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mails_incoming_events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mails_incoming_id', 'events_id'], 'required'],
            [['mails_incoming_id', 'events_id'], 'integer'],
            [['mails_incoming_id', 'events_id'], 'unique', 'targetAttribute' => ['mails_incoming_id', 'events_id']],
            [['events_id'], 'exist', 'skipOnError' => true, 'targetClass' => Events::className(), 'targetAttribute' => ['events_id' => 'id']],
            [['mails_incoming_id'], 'exist', 'skipOnError' => true, 'targetClass' => MailsIncoming::className(), 'targetAttribute' => ['mails_incoming_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mails_incoming_id' => Yii::t('app', 'Mails Incoming ID'),
            'events_id' => Yii::t('app', 'Events ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasOne(Events::className(), ['id' => 'events_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailsIncoming()
    {
        return $this->hasOne(MailsIncoming::className(), ['id' => 'mails_incoming_id']);
    }
}
