<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mails_incoming".
 *
 * @property int $id
 * @property string $in_num
 * @property string $in_date
 * @property string $out_num
 * @property string $out_date
 * @property string $organization
 * @property string $description
 * @property string $deadline
 * @property string $result
 * @property string $dcreated
 * @property int $bycreated
 *
 * @property User $bycreated0
 * @property MailsIncomingEvents[] $mailsIncomingEvents
 * @property Events[] $events
 * @property MailsIncomingMailsOutgoing[] $mailsIncomingMailsOutgoings
 * @property MailsOutgoing[] $mailsOutgoings
 * @property MailsIncomingUser[] $mailsIncomingUsers
 * @property User[] $users
 */
class MailsIncoming extends \yii\db\ActiveRecord
{
    public $files;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mails_incoming';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['in_date', 'out_date', 'deadline', 'dcreated'], 'safe'],
            [['dcreated', 'bycreated'], 'required'],
            [['bycreated'], 'integer'],
            [['in_num', 'out_num', 'organization', 'description', 'result'], 'string', 'max' => 255],
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
            'in_num' => Yii::t('app', 'In Num'),
            'in_date' => Yii::t('app', 'In Date'),
            'out_num' => Yii::t('app', 'Out Num'),
            'out_date' => Yii::t('app', 'Out Date'),
            'organization' => Yii::t('app', 'Organization'),
            'description' => Yii::t('app', 'Description'),
            'deadline' => Yii::t('app', 'Deadline'),
            'result' => Yii::t('app', 'Result'),
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
        return $this->hasMany(MailsIncomingEvents::className(), ['mails_incoming_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Events::className(), ['id' => 'events_id'])->viaTable('mails_incoming_events', ['mails_incoming_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailsIncomingMailsOutgoings()
    {
        return $this->hasMany(MailsIncomingMailsOutgoing::className(), ['mails_incoming_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailsOutgoings()
    {
        return $this->hasMany(MailsOutgoing::className(), ['id' => 'mails_outgoing_id'])->viaTable('mails_incoming_mails_outgoing', ['mails_incoming_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailsIncomingUsers()
    {
        return $this->hasMany(MailsIncomingUser::className(), ['mails_incoming_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('mails_incoming_user', ['mails_incoming_id' => 'id']);
    }
}
