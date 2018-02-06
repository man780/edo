<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mails_incoming`.
 */
class m180201_070142_create_mails_incoming_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%mails_incoming}}', [
            'id' => $this->primaryKey(),
            'in_num' => $this->string(),
            'in_date' => $this->dateTime(),
            'out_num' => $this->string(),
            'out_date' => $this->date(),
            'organization' => $this->string(),
            'description' => $this->string(),
            'deadline' => $this->dateTime(),
            'result' => $this->string(),
            'dcreated' => $this->dateTime()->notNull(),
            'bycreated' => $this->integer()->notNull(),
        ]);

        // creates index for column `direction_id`
        $this->createIndex(
            'idx-mails_incoming-bycreated',
            '{{%mails_incoming}}',
            'bycreated'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-mails_incoming-bycreated',
            '{{%mails_incoming}}',
            'bycreated',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%mails_incoming}}');
    }
}
