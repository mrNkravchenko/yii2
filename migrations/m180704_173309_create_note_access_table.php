<?php

use yii\db\Migration;

/**
 * Handles the creation of table `note_access`.
 */
class m180704_173309_create_note_access_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `evrnt_access` (
              `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
              `note_id` INT NOT NULL COMMENT '',
              `user_id` INT NOT NULL COMMENT '',
              PRIMARY KEY (`id`)  COMMENT '',
              INDEX `fk_evrnt_access_1_idx` (`note_id` ASC)  COMMENT '',
              INDEX `fk_evrnt_access_2_idx` (`user_id` ASC)  COMMENT '')
            ENGINE = InnoDB CHARACTER SET UTF8
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('note_access');
    }
}
