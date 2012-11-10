<?php

class m121109_182406_registration_code_table extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->createTable('registration_code',array(
            'id'=> 'pk',
            'user_id' => 'integer NOT NULL',
            'token' => 'string NOT NULL',
            'dateCreated' => 'date NOT NULL',
        ),'ENGINE=InnoDB');
        $this->addForeignKey('fk_user_rc','registration_code','user_id','user','id','cascade','cascade');

        $this->addColumn('user','account_locked','boolean');
	}

	public function safeDown()
	{
        $this->dropForeignKey('fk_user_rc','registration_code');
        $this->dropTable('registration_code');
        $this->dropColumn('user','account_locked');
	}
}