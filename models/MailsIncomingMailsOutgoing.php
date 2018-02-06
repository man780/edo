<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mails_incoming_mails_outgoing".
 *
 * @property int $mails_incoming_id
 * @property int $mails_outgoing_id
 * @property string $created_at
 *
 * @property MailsOutgoing $mailsOutgoing
 * @property MailsIncoming $mailsIncoming
 */
class MailsIncomingMailsOutgoing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mails_incoming_mails_outgoing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mails_incoming_id', 'mails_outgoing_id'], 'required'],
            [['mails_incoming_id', 'mails_outgoing_id'], 'integer'],
            [['created_at'], 'safe'],
            [['mails_incoming_id', 'mails_outgoing_id'], 'unique', 'targetAttribute' => ['mails_incoming_id', 'mails_outgoing_id']],
            [['mails_outgoing_id'], 'exist', 'skipOnError' => true, 'targetClass' => MailsOutgoing::className(), 'targetAttribute' => ['mails_outgoing_id' => 'id']],
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
            'mails_outgoing_id' => Yii::t('app', 'Mails Outgoing ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailsOutgoing()
    {
        return $this->hasOne(MailsOutgoing::className(), ['id' => 'mails_outgoing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailsIncoming()
    {
        return $this->hasOne(MailsIncoming::className(), ['id' => 'mails_incoming_id']);
    }
}
