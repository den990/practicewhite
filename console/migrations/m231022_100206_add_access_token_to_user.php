<?php

use \yii\db\Migration;

class m231022_100206_add_access_token_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'access_token', $this->string()->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'access_token');
    }
}