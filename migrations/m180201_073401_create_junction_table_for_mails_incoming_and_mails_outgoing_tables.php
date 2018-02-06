<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mails_incoming_mails_outgoing`.
 * Has foreign keys to the tables:
 *
 * - `mails_incoming`
 * - `mails_outgoing`
 */
class m180201_073401_create_junction_table_for_mails_incoming_and_mails_outgoing_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('mails_incoming_mails_outgoing', [
            'mails_incoming_id' => $this->integer(),
            'mails_outgoing_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'PRIMARY KEY(mails_incoming_id, mails_outgoing_id)',
        ]);

        // creates index for column `mails_incoming_id`
        $this->createIndex(
            'idx-mails_incoming_mails_outgoing-mails_incoming_id',
            'mails_incoming_mails_outgoing',
            'mails_incoming_id'
        );

        // add foreign key for table `mails_incoming`
        $this->addForeignKey(
            'fk-mails_incoming_mails_outgoing-mails_incoming_id',
            'mails_incoming_mails_outgoing',
            'mails_incoming_id',
            'mails_incoming',
            'id',
            'CASCADE'
        );

        // creates index for column `mails_outgoing_id`
        $this->createIndex(
            'idx-mails_incoming_mails_outgoing-mails_outgoing_id',
            'mails_incoming_mails_outgoing',
            'mails_outgoing_id'
        );

        // add foreign key for table `mails_outgoing`
        $this->addForeignKey(
            'fk-mails_incoming_mails_outgoing-mails_outgoing_id',
            'mails_incoming_mails_outgoing',
            'mails_outgoing_id',
            'mails_outgoing',
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
            'fk-mails_incoming_mails_outgoing-mails_incoming_id',
            'mails_incoming_mails_outgoing'
        );

        // drops index for column `mails_incoming_id`
        $this->dropIndex(
            'idx-mails_incoming_mails_outgoing-mails_incoming_id',
            'mails_incoming_mails_outgoing'
        );

        // drops foreign key for table `mails_outgoing`
        $this->dropForeignKey(
            'fk-mails_incoming_mails_outgoing-mails_outgoing_id',
            'mails_incoming_mails_outgoing'
        );

        // drops index for column `mails_outgoing_id`
        $this->dropIndex(
            'idx-mails_incoming_mails_outgoing-mails_outgoing_id',
            'mails_incoming_mails_outgoing'
        );

        $this->dropTable('mails_incoming_mails_outgoing');
    }
}
