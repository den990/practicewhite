<?php

use yii\db\Migration;

/**
 * Class m231031_184723_init_table_acces_token
 */
class m231031_184723_init_table_acces_token extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%accesses_token}}', [
            'id' => $this->primaryKey(),
            'idUser' => $this->integer()->notNull(),
            'accessToken' => $this->string()->defaultValue(null),
        ], $tableOptions);
        $this->addForeignKey('fk-idUser_accesses_token-id_user',
            '{{%accesses_token}}',
            'idUser',
            '{{%user}}',
            'id');
    }

    public function down()
    {
        $this->dropTable('{{%accesses_token}}');
        $this->dropForeignKey('fk-idUser_accesses_token-id_user', '{{%accesses_token}}');
    }

}
