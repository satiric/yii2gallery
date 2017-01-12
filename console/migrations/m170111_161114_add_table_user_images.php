<?php

use yii\db\Migration;

class m170111_161114_add_table_user_images extends Migration
{
    public function safeUp()
    {
        $this->createTable('user_files', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'file_name' => $this->string(255)->notNull(),
            'title' => $this->string(255)->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'deleted_at' => $this->integer()->null(),
            'deleted_by' => $this->integer()->null()
        ]);
        $this->addForeignKey('fk-user_files-user_id', 'user_files', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-user_files-user_id', 'user_files');
        $this->dropTable('user_files');
    }

}
