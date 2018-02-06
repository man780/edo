<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mails_outgoing_user".
 *
 * @property int $mails_outgoing_id
 * @property int $user_id
 * @property string $created_at
 *
 * @property User $user
 * @property MailsOutgoing $mailsOutgoing
 */
class MailsOutgoingUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mails_outgoing_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mails_outgoing_id', 'user_id'], 'required'],
            [['mails_outgoing_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['mails_outgoing_id', 'user_id'], 'unique', 'targetAttribute' => ['mails_outgoing_id', 'user_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
    public function getMailsOutgoing()
    {
        return $this->hasOne(MailsOutgoing::className(), ['id' => 'mails_outgoing_id']);
    }
}
