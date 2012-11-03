<?php

class m121101_113006_rename_contact_column extends CDbMigration
{
	public function safeUp()
	{
        $this->renameColumn('contact','like','c_like');
	}

	public function safeDown()
	{
        $this->renameColumn('contact','c_like','like');
	}
}