<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180704_172626_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('
            create table user
(
	id int auto_increment
		primary key,
	username varchar(255) not null,
	surname varchar(255) not null,
	name varchar(255) not null,
	password varchar(255) not null,
	salt varchar(255) null,
	access_token varchar(255) not null,
	create_date timestamp default CURRENT_TIMESTAMP not null,
	confirm tinyint(1) default \'0\' not null,
	constraint user_username_uindex
		unique (username),
	constraint user_access_token_uindex
		unique (access_token)
)

        ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
