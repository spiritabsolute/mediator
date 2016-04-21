<?php

use yii\db\Schema;
use yii\db\Migration;

class m160421_202939_add_column_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'name', $this->string());
        $this->addColumn('{{%user}}', 'surname', $this->string());
        $this->addColumn('{{%user}}', 'age', $this->smallInteger());
        $this->addColumn('{{%user}}', 'date_birth', $this->date());
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'name');
        $this->dropColumn('{{%user}}', 'surname');
        $this->dropColumn('{{%user}}', 'age');
        $this->dropColumn('{{%user}}', 'date_birth');
    }
}
