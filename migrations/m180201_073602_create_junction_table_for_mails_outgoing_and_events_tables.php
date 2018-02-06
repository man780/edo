<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mails_outgoing_events`.
 * Has foreign keys to the tables:
 *
 * - `mails_outgoing`
 * - `events`
 */
class m180201_073602_create_junction_table_for_mails_outgoing_and_events_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('mails_outgoing_events', [
            'mails_outgoing_id' => $this->integer(),
            'events_id' => $this->integer(),
            'PRIMARY KEY(mails_outgoing_id, events_id)',
        ]);

        // creates index for column `mails_outgoing_id`
        $this->createIndex(
            'idx-mails_outgoing_events-mails_outgoing_id',
            'mails_outgoing_events',
            'mails_outgoing_id'
        );

        // add foreign key for table `mails_outgoing`
        $this->addForeignKey(
            'fk-mails_outgoing_events-mails_outgoing_id',
            'mails_outgoing_events',
            'mails_outgoing_id',
            'mails_outgoing',
            'id',
            'CASCADE'
        );

        // creates index for column `events_id`
        $this->createIndex(
            'idx-mails_outgoing_events-events_id',
            'mails_outgoing_events',
            'events_id'
        );

        // add foreign key for table `events`
        $this->addForeignKey(
            'fk-mails_outgoing_events-events_id',
            'mails_outgoing_events',
            'events_id',
            'events',
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
            'fk-mails_outgoing_events-mails_outgoing_id',
            'mails_outgoing_events'
        );

        // drops index for column `mails_outgoing_id`
        $this->dropIndex(
            'idx-mails_outgoing_events-mails_outgoing_id',
            'mails_outgoing_events'
        );

        // drops foreign key for table `events`
        $this->dropForeignKey(
            'fk-mails_outgoing_events-events_id',
            'mails_outgoing_events'
        );

        // drops index for column `events_id`
        $this->dropIndex(
            'idx-mails_outgoing_events-events_id',
            'mails_outgoing_events'
        );

        $this->dropTable('mails_outgoing_events');
    }
}
