<?php
/**
 * Author: Duc Nguyen Ta Quang <ducntq@gmail.com>
 *
 * Automatically convert date and datetime field to PHP5 DateTime object
 *
 * Inspired from DateTimeI18NBehavior
 *
 * Date: 5/15/12
 * Time: 2:14 PM
 * Version: 1.0.0
 * Tested with yii-1.1.10.r3566
 */

class EDateTimeBehavior extends CActiveRecordBehavior
{
    private $mySqlDateFormat = 'Y-m-d';
    private $pgridzDateFormat = 'm/d/Y';

    public function afterFind($event)
    {
        foreach($event->sender->tableSchema->columns as $columnName => $column){
            if (($column->dbType != 'date')) continue;

            if (!strlen($event->sender->$columnName)){
                $event->sender->$columnName = null;
                continue;
            }

            $format=DateTime::createFromFormat($this->mySqlDateFormat,$event->sender->$columnName);
            $event->sender->$columnName=$format->format($this->pgridzDateFormat);
        }
        parent::afterFind($event);
    }

    public function beforeSave($event)
    {
        foreach($event->sender->tableSchema->columns as $columnName => $column){
            if (($column->dbType != 'date')) continue;

            if (!strlen($event->sender->$columnName)){
                $event->sender->$columnName = null;
                continue;
            }

            if (($column->dbType == 'date'))
            {
                $format=DateTime::createFromFormat($this->pgridzDateFormat,$event->sender->$columnName);
                $sqlDate = $format->format($this->mySqlDateFormat);
                $event->sender->$columnName = $sqlDate;
            }
        }
        parent::beforeSave($event);
    }
}
