<?php
use yii\db\Migration;

class m160422_200527_create_event_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'entity' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'author' => $this->integer()->notNull(),
            'changes' => $this->text(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%event}}');
    }
}
