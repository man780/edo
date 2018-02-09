<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "mails_outgoing".
 *
 * @property int $id
 * @property string $num
 * @property string $date
 * @property string $organization
 * @property string $description
 * @property string $result
 * @property string $dcreated
 * @property int $bycreated
 *
 * @property MailsIncomingMailsOutgoing[] $mailsIncomingMailsOutgoings
 * @property MailsIncoming[] $mailsIncomings
 * @property User $bycreated0
 * @property MailsOutgoingEvents[] $mailsOutgoingEvents
 * @property Events[] $events
 * @property MailsOutgoingUser[] $mailsOutgoingUsers
 * @property User[] $users
 */
class MailsOutgoing extends \yii\db\ActiveRecord
{
    public $files;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mails_outgoing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'dcreated'], 'safe'],
            //[['dcreated', 'bycreated'], 'required'],
            [['bycreated'], 'integer'],
            [['num', 'organization', 'description', 'result'], 'string', 'max' => 255],
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
            'num' => Yii::t('app', 'Num'),
            'date' => Yii::t('app', 'Date'),
            'organization' => Yii::t('app', 'Organization'),
            'description' => Yii::t('app', 'Description'),
            'result' => Yii::t('app', 'Result'),
            'dcreated' => Yii::t('app', 'Dcreated'),
            'bycreated' => Yii::t('app', 'Bycreated'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getMailsIncomingMailsOutgoings()
    {
        return $this->hasMany(MailsIncomingMailsOutgoing::className(), ['mails_outgoing_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailsIncomings()
    {
        return $this->hasMany(MailsIncoming::className(), ['id' => 'mails_incoming_id'])->viaTable('mails_incoming_mails_outgoing', ['mails_outgoing_id' => 'id']);
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
    public function getMailsOutgoingEvents()
    {
        return $this->hasMany(MailsOutgoingEvents::className(), ['mails_outgoing_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Events::className(), ['id' => 'events_id'])->viaTable('mails_outgoing_events', ['mails_outgoing_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailsOutgoingUsers()
    {
        return $this->hasMany(MailsOutgoingUser::className(), ['mails_outgoing_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('mails_outgoing_user', ['mails_outgoing_id' => 'id']);
    }

    public function getUsersAll()
    {
        return ArrayHelper::map(User::find()->all(), 'id', 'username');
    }
}
