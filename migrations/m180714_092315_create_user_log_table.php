<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_log`.
 */
class m180714_092315_create_user_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_log', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'login_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->createIndex('user_id', 'user_log', 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_log');
    }
}
