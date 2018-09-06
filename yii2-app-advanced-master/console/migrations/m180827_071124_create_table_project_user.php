<?php

use yii\db\Migration;

/**
 * Class m180827_071124_create_table_project_user
 */
class m180827_071124_create_table_project_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project_user', [
            'project_id' => $this->integer()->notNull()->comment('ID проекта'),
            'user_id' => $this->integer()->notNull()->comment('ID пользователя'),
            'role' => 'ENUM("manager", "developer", "tester")'
        ]);

        $sql = "ALTER TABLE project_user ALTER role SET DEFAULT 'developer'";
        $this->execute($sql);

        $this->addForeignKey('fx_project_user_user', 'project_user', ['user_id'],
            'user', ['id']);
        $this->addForeignKey('fx_project_user_project', 'project_user', ['project_id'],
            'project', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_project_user_user', 'project_user');
        $this->dropForeignKey('fx_project_user_project', 'project_user');
        $this->dropIndex('fx_project_user_user', 'project_user');
        $this->dropIndex('fx_project_user_project', 'project_user');

        $this->dropTable('project_user');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_071124_create_table_project_user cannot be reverted.\n";

        return false;
    }
    */
}
