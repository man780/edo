<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mails_outgoing`.
 */
class m180201_070157_create_mails_outgoing_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%mails_outgoing}}', [
            'id' => $this->primaryKey(),
            'num' => $this->string(),
            'date' => $this->dateTime(),
            'organization' => $this->string(),
            'description' => $this->string(),
            'result' => $this->string(),
            'dcreated' => $this->dateTime()->notNull(),
            'bycreated' => $this->integer()->notNull(),
        ]);

        // creates index for column `direction_id`
        $this->createIndex(
            'idx-mails_outgoing-bycreated',
            '{{%mails_outgoing}}',
            'bycreated'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-mails_outgoing-bycreated',
            '{{%mails_outgoing}}',
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
        $this->dropTable('{{%mails_outgoing}}');
    }
}
