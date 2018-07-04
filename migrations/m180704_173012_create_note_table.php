<?php

use yii\db\Migration;

/**
 * Handles the creation of table `note`.
 */
class m180704_173012_create_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `evrnt_note` (
              `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
              `text` TEXT NOT NULL COMMENT '',
              `creator` INT NOT NULL COMMENT '',
              `date_create` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
              PRIMARY KEY (`id`)  COMMENT '',
              INDEX `fk_evrnt_note_1_idx` (`creator` ASC)  COMMENT '')
            ENGINE = InnoDB CHARACTER SET UTF8
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('note');
    }
}
