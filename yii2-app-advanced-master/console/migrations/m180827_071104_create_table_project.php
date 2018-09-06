<?php

use yii\db\Migration;

/**
 * Class m180827_071104_create_table_project
 */
class m180827_071104_create_table_project extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project', [
            'id' => $this->primaryKey()->comment('ID'),
            'title' => $this->string()->notNull()->comment('Заголовок'),
            'description' => $this->text()->notNull()->comment('Описание'),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()
        ]);

        $this->addForeignKey('fx_project_user', 'project', ['created_by'],
            'user', ['id']);
        $this->addForeignKey('fx_project_user_2', 'project', ['updated_by'],
            'user', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_project_user', 'project');
        $this->dropForeignKey('fx_project_user_2', 'project');
        $this->dropIndex('fx_project_user', 'project');
        $this->dropIndex('fx_project_user_2', 'project');

        $this->dropTable('project');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_071104_create_table_project cannot be reverted.\n";

        return false;
    }
    */
}
