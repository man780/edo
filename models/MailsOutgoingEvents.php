<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mails_outgoing_events".
 *
 * @property int $mails_outgoing_id
 * @property int $events_id
 *
 * @property Events $events
 * @property MailsOutgoing $mailsOutgoing
 */
class MailsOutgoingEvents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mails_outgoing_events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mails_outgoing_id', 'events_id'], 'required'],
            [['mails_outgoing_id', 'events_id'], 'integer'],
            [['mails_outgoing_id', 'events_id'], 'unique', 'targetAttribute' => ['mails_outgoing_id', 'events_id']],
            [['events_id'], 'exist', 'skipOnError' => true, 'targetClass' => Events::className(), 'targetAttribute' => ['events_id' => 'id']],
            [['mails_outgoing_id'], 'exist', 'skipOnError' => true, 'targetClass' => MailsOutgoing::className(), 'targetAttribute' => ['mails_outgoing_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mails_outgoing_id' => Yii::t('app', 'Mails Outgoing ID'),
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
    public function getMailsOutgoing()
    {
        return $this->hasOne(MailsOutgoing::className(), ['id' => 'mails_outgoing_id']);
    }
}
