<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mails_incoming_events`.
 * Has foreign keys to the tables:
 *
 * - `mails_incoming`
 * - `events`
 */
class m180201_073622_create_junction_table_for_mails_incoming_and_events_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('mails_incoming_events', [
            'mails_incoming_id' => $this->integer(),
            'events_id' => $this->integer(),
            'PRIMARY KEY(mails_incoming_id, events_id)',
        ]);

        // creates index for column `mails_incoming_id`
        $this->createIndex(
            'idx-mails_incoming_events-mails_incoming_id',
            'mails_incoming_events',
            'mails_incoming_id'
        );

        // add foreign key for table `mails_incoming`
        $this->addForeignKey(
            'fk-mails_incoming_events-mails_incoming_id',
            'mails_incoming_events',
            'mails_incoming_id',
            'mails_incoming',
            'id',
            'CASCADE'
        );

        // creates index for column `events_id`
        $this->createIndex(
            'idx-mails_incoming_events-events_id',
            'mails_incoming_events',
            'events_id'
        );

        // add foreign key for table `events`
        $this->addForeignKey(
            'fk-mails_incoming_events-events_id',
            'mails_incoming_events',
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
        // drops foreign key for table `mails_incoming`
        $this->dropForeignKey(
            'fk-mails_incoming_events-mails_incoming_id',
            'mails_incoming_events'
        );

        // drops index for column `mails_incoming_id`
        $this->dropIndex(
            'idx-mails_incoming_events-mails_incoming_id',
            'mails_incoming_events'
        );

        // drops foreign key for table `events`
        $this->dropForeignKey(
            'fk-mails_incoming_events-events_id',
            'mails_incoming_events'
        );

        // drops index for column `events_id`
        $this->dropIndex(
            'idx-mails_incoming_events-events_id',
            'mails_incoming_events'
        );

        $this->dropTable('mails_incoming_events');
    }
}
