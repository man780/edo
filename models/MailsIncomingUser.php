<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mails_incoming_user".
 *
 * @property int $mails_incoming_id
 * @property int $user_id
 * @property string $created_at
 *
 * @property User $user
 * @property MailsIncoming $mailsIncoming
 */
class MailsIncomingUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mails_incoming_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mails_incoming_id', 'user_id'], 'required'],
            [['mails_incoming_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['mails_incoming_id', 'user_id'], 'unique', 'targetAttribute' => ['mails_incoming_id', 'user_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailsIncoming()
    {
        return $this->hasOne(MailsIncoming::className(), ['id' => 'mails_incoming_id']);
    }
}
