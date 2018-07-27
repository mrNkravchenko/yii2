<?php

use yii\db\Migration;

/**
 * Handles the creation of table `url_shortener`.
 */
class m180718_184637_create_url_shortener_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('url_shortener' , [
            'id' => $this->primaryKey(),
            'url_origin' => $this->string()->notNull()->unique(),
            'url_short' => $this->string()->notNull()->unique(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'count_of_use' => $this->integer()->defaultValue(0),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('url_shortener');
    }
}
