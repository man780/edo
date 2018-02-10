<?php

use yii\db\Migration;

/**
 * Handles the creation of table `structure`.
 */
class m180210_071047_create_structure_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('structure', [
            'id' => $this->primaryKey(),
            'num' => $this->string(),
            'name' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('structure');
    }
}
