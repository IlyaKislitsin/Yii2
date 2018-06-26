<?php

use yii\db\Migration;

/**
 * Class m180619_064605_create_table_user
 */
class m180619_064605_create_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey()->comment('ID пользователя'),
            'username' => $this->string()->notNull()->comment('Логин'),
            'name' => $this->string()->notNull()->comment('Имя'),
            'surname' => $this->string()->comment('Фамилия'),
            'password_hash' => $this->string()->notNull()->comment('hash пароля'),
            'access_token' => $this->string(),
            'auth_key' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180619_064605_create_table_user cannot be reverted.\n";

        return false;
    }
    */
}
