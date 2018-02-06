<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mails_outgoing_user`.
 * Has foreign keys to the tables:
 *
 * - `mails_outgoing`
 * - `user`
 */
class m180201_073511_create_junction_table_for_mails_outgoing_and_user_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('mails_outgoing_user', [
            'mails_outgoing_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'PRIMARY KEY(mails_outgoing_id, user_id)',
        ]);

        // creates index for column `mails_outgoing_id`
        $this->createIndex(
            'idx-mails_outgoing_user-mails_outgoing_id',
            'mails_outgoing_user',
            'mails_outgoing_id'
        );

        // add foreign key for table `mails_outgoing`
        $this->addForeignKey(
            'fk-mails_outgoing_user-mails_outgoing_id',
            'mails_outgoing_user',
            'mails_outgoing_id',
            'mails_outgoing',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-mails_outgoing_user-user_id',
            'mails_outgoing_user',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-mails_outgoing_user-user_id',
            'mails_outgoing_user',
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
        // drops foreign key for table `mails_outgoing`
        $this->dropForeignKey(
            'fk-mails_outgoing_user-mails_outgoing_id',
            'mails_outgoing_user'
        );

        // drops index for column `mails_outgoing_id`
        $this->dropIndex(
            'idx-mails_outgoing_user-mails_outgoing_id',
            'mails_outgoing_user'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-mails_outgoing_user-user_id',
            'mails_outgoing_user'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-mails_outgoing_user-user_id',
            'mails_outgoing_user'
        );

        $this->dropTable('mails_outgoing_user');
    }
}
