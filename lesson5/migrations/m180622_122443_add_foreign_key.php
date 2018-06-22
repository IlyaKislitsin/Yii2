<?php

use yii\db\Migration;

/**
 * Class m180622_122443_add_foreign_key
 */
class m180622_122443_add_foreign_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_access_user', 'access', ['user_id'], 'user', ['id']);
        $this->addForeignKey('fk_access_event', 'access', ['event_id'], 'event', ['id']);
        $this->addForeignKey('fk_event_user', 'event', ['creator_id'], 'user', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_access_user', 'access');
        $this->dropForeignKey('fk_access_event', 'access');
        $this->dropForeignKey('fk_event_user', 'event');
        $this->dropIndex('fk_access_user', 'access');
        $this->dropIndex('fk_access_event', 'access');
        $this->dropIndex('fk_event_user', 'event');


        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180622_122443_add_foreign_key cannot be reverted.\n";

        return false;
    }
    */
}
