<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mails_incoming_mails_outgoing".
 *
 * @property int $mails_incoming_id
 * @property int $mails_outgoing_id
 * @property string $created_at
 * @property string $direction
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
            [['created_at', 'direction'], 'safe'],
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
            'direction' => Yii::t('app', 'Direction'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->created_at = date('Y-m-d H:i:s', time()+2*3600);
            return true;
        } else {
            return false;
        }
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
