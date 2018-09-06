<?php

use yii\db\Migration;

/**
 * Handles adding active to table `project`.
 */
class m180902_124631_add_active_column_to_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('project', 'active',
            $this->boolean()->after('description')->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('project', 'active');
    }
}
