<?php

class m121024_135759_base_tables extends CDbMigration
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
            'join_date' => 'date NOT NULL',
            'end_date' => 'date DEFAULT NULL',
            'UNIQUE KEY `email` (`email`)',
        ),'ENGINE=InnoDB');
        $this->createTable('company',array(
            'id'=> 'pk',
            'user_id' => 'integer DEFAULT NULL',
            'name' => 'string NOT NULL',
        ),'ENGINE=InnoDB');
        $this->createTable('contact',array(
            'id'=> 'integer NOT NULL AUTO_INCREMENT',
            'user_id' => 'integer NOT NULL',
            'company_id' => 'integer NOT NULL',
            'name' => 'string NOT NULL',
            'title' => 'string DEFAULT NULL',
            'group_division' => 'string DEFAULT NULL',
            'city' => 'string DEFAULT NULL',
            'country' => 'string DEFAULT NULL',
            'phone' => 'string DEFAULT NULL',
            'email' => 'string DEFAULT NULL',
            'school' => 'string DEFAULT NULL',
            'notes' => 'text DEFAULT NULL',
            'questions_to_ask' => 'text DEFAULT NULL',
            'iq' => 'int(1) DEFAULT NULL',
            'like' => 'int(1) DEFAULT NULL',
            'PRIMARY KEY (`id`, `user_id`,`company_id`)'
        ),'ENGINE=InnoDB');
        $this->addForeignKey('fk_user_contacts','contact','user_id','user','id','cascade','cascade');
        $this->addForeignKey('fk_company_contacts','contact','company_id','company','id','cascade','cascade');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_user_contacts','contact');
        $this->dropForeignKey('fk_company_contacts','contact');
        $this->dropTable('contact');
        $this->dropTable('company');
        $this->dropTable('user');
    }
}
