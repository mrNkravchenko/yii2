<?php

use yii\db\Migration;

/**
 * Class m180709_182411_add_access_date_column
 */
class m180709_182411_add_access_date_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    /*public function safeUp()
    {

    }*/

    /**
     * {@inheritdoc}
     */
    /*public function safeDown()
    {
        echo "m180709_182411_add_access_date_column cannot be reverted.\n";

        return false;
    }*/


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        parent::up();
        $this->addColumn(\app\models\Access::tableName(), 'since', $this->dateTime());
        return true;

    }

    public function down()
    {
        parent::down();
        $this->dropColumn(\app\models\Access::tableName(), 'since');
        return true;
    }

}
