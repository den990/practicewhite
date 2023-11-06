<?php

use yii\db\Migration;

/**
 * Class m231106_212650_create_user_role
 */
class m231106_212650_create_user_role extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_role}}', [
            'id' => $this->primaryKey(),
            'idUser' => $this->integer()->notNull(),
            'role' => $this->integer()->notNull()
        ], $tableOptions);
        $this->addForeignKey('fk-idUser_user_role-id_user',
            '{{%user_role}}',
            'idUser',
            '{{%user}}',
            'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk-idUser_user_role-id_user', 'user_role');
        $this->dropTable('{{%user_role}}');
    }


}
