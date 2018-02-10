<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10.02.2018
 * Time: 21:32
 */

use yii\db\Migration;

/**
 * Handles adding structure_id to table `mails_outgoing`.
 * Has foreign keys to the tables:
 *
 * - `structure`
 */
class m190210_074842_add_structure_id_column_to_mails_outgoing_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('mails_outgoing', 'structure_id', $this->integer(11)->notNull()->after('id'));

        // creates index for column `structure_id`
        $this->createIndex(
            'idx-mails_outgoing-structure_id',
            'mails_outgoing',
            'structure_id'
        );

        // add foreign key for table `structure`
        $this->addForeignKey(
            'fk-mails_outgoing-structure_id',
            'mails_outgoing',
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
            'fk-mails_outgoing-structure_id',
            'mails_outgoing'
        );

        // drops index for column `structure_id`
        $this->dropIndex(
            'idx-mails_outgoing-structure_id',
            'mails_outgoing'
        );

        $this->dropColumn('mails_outgoing', 'structure_id');
    }
}
