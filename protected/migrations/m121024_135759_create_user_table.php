<?php

class m121024_135759_create_user_table extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->createTable('user',array(
            'id'=> 'pk',
            'email' => 'string NOT NULL',
            'password' => 'string NOT NULL',
            'city_id' => 'integer DEFAULT NULL',
            'state_id' => 'integer DEFAULT NULL',
            'country_id' => 'integer DEFAULT NULL',
            'zip' => 'string DEFAULT NULL',
            'join_date' => 'datetime NOT NULL',
            'end_date' => 'datetime DEFAULT NULL',
            'firm' => 'string DEFAULT NULL',
            'UNIQUE KEY `email` (`email`)',
        ),'ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('user');
    }
}
