<?php

use yii\db\Migration;

/**
 * Class m231120_100018_init_table_comment
 */
class m231120_100018_init_table_comment extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string()->notNull(),
            'userId'=> $this->integer()->notNull(),
            'blogId' => $this->integer()->notNull()
        ], $tableOptions);
        $this->addForeignKey('fk-userId_comment-id_user',
            '{{%comments}}',
            'userId',
            '{{%user}}',
            'id');
        $this->addForeignKey('fk-blogId_commnt-id_blog',
        '{{%comments}}',
        'blogId',
        '{{%blogs}}',
        'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk-userId_comment-id_user', '{{%comments}}');
        $this->dropForeignKey('fk-blogId_commnt-id_blog', '{{%comments}}');
        $this->dropTable('{{%comments}}');
    }
}
