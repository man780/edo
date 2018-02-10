<?php

use yii\db\Migration;

/**
 * Handles adding structure_id to table `mails_incoming`.
 * Has foreign keys to the tables:
 *
 * - `structure`
 */
class m180210_074842_add_structure_id_column_to_mails_incoming_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('mails_incoming', 'structure_id', $this->integer(11)->notNull()->after('id'));

        // creates index for column `structure_id`
        $this->createIndex(
            'idx-mails_incoming-structure_id',
            'mails_incoming',
            'structure_id'
        );

        // add foreign key for table `structure`
        $this->addForeignKey(
            'fk-mails_incoming-structure_id',
            'mails_incoming',
            'structure_id',
            'structure',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `structure`
        $this->dropForeignKey(
            'fk-mails_incoming-structure_id',
            'mails_incoming'
        );

        // drops index for column `structure_id`
        $this->dropIndex(
            'idx-mails_incoming-structure_id',
            'mails_incoming'
        );

        $this->dropColumn('mails_incoming', 'structure_id');
    }
}
