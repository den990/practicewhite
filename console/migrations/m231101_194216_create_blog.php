<?php

use yii\db\Migration;

/**
 * Class m231101_194216_create_blog
 */
class m231101_194216_create_blog extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%blogs}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string()->notNull(),
            'idUser'=> $this->integer()->notNull()
        ], $tableOptions);
        $this->addForeignKey('fk-idUser_blogs-id_user',
        '{{%blogs}}',
        'idUser',
        '{{%user}}',
        'id');
    }

    public function down()
    {
        $this->dropTable('{{%blogs}}');
        $this->dropForeignKey('fk-idUser_blogs-id_user', '{{%blogs}}');
    }
}
