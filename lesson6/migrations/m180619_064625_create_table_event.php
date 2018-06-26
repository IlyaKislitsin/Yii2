<?php

use yii\db\Migration;

/**
 * Class m180619_064625_create_table_event
 */
class m180619_064625_create_table_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('event', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->notNull(),
            'dt' => $this->dateTime()->notNull(),
            'creator_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('event');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180619_064625_create_table_event cannot be reverted.\n";

        return false;
    }
    */
}
