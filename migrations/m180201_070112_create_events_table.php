<?php

use yii\db\Migration;

/**
 * Handles the creation of table `events`.
 */
class m180201_070112_create_events_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%events}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->string(),
            'datetime' => $this->dateTime(),
            'place' => $this->string(),
            'dcreated' => $this->dateTime(),
            'bycreated' => $this->integer(),
        ]);

        // creates index for column `direction_id`
        $this->createIndex(
            'idx-events-bycreated',
            '{{%events}}',
            'bycreated'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-events-bycreated',
            '{{%events}}',
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
        $this->dropTable('{{%events}}');
    }
}
