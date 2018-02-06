<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mails_incoming_user`.
 * Has foreign keys to the tables:
 *
 * - `mails_incoming`
 * - `user`
 */
class m180201_073448_create_junction_table_for_mails_incoming_and_user_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('mails_incoming_user', [
            'mails_incoming_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'PRIMARY KEY(mails_incoming_id, user_id)',
        ]);

        // creates index for column `mails_incoming_id`
        $this->createIndex(
            'idx-mails_incoming_user-mails_incoming_id',
            'mails_incoming_user',
            'mails_incoming_id'
        );

        // add foreign key for table `mails_incoming`
        $this->addForeignKey(
            'fk-mails_incoming_user-mails_incoming_id',
            'mails_incoming_user',
            'mails_incoming_id',
            'mails_incoming',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-mails_incoming_user-user_id',
            'mails_incoming_user',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-mails_incoming_user-user_id',
            'mails_incoming_user',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `mails_incoming`
        $this->dropForeignKey(
            'fk-mails_incoming_user-mails_incoming_id',
            'mails_incoming_user'
        );

        // drops index for column `mails_incoming_id`
        $this->dropIndex(
            'idx-mails_incoming_user-mails_incoming_id',
            'mails_incoming_user'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-mails_incoming_user-user_id',
            'mails_incoming_user'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-mails_incoming_user-user_id',
            'mails_incoming_user'
        );

        $this->dropTable('mails_incoming_user');
    }
}
