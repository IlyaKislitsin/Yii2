<?php

use yii\db\Migration;

/**
 * Class m180827_071015_create_table_task
 */
class m180827_071015_create_table_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey()->comment('ID'),
            'title' => $this->string()->notNull()->comment('Заголовок'),
            'description' => $this->text()->notNull()->comment('Описание'),
            'estimation' => $this->integer()->notNull(),
            'executor_id' => $this->integer(),
            'started_at' => $this->integer(),
            'completed_at' => $this->integer(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()
        ]);
        $this->addForeignKey('fx_task_user', 'task', ['executor_id'],
            'user', ['id']);
        $this->addForeignKey('fx_task_user_2', 'task', ['created_by'],
            'user', ['id']);
        $this->addForeignKey('fx_task_user_3', 'task', ['updated_by'],
            'user', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_task_user', 'task');
        $this->dropForeignKey('fx_task_user_2', 'task');
        $this->dropForeignKey('fx_task_user_3', 'task');
        $this->dropIndex('fx_task_user', 'task');
        $this->dropIndex('fx_task_user_2', 'task');
        $this->dropIndex('fx_task_user_3', 'task');

        $this->dropTable('task');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_071015_create_table_task cannot be reverted.\n";

        return false;
    }
    */
}
