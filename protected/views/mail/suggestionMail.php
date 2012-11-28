Dear admin,<br/><br/>
<?php echo CHtml::link($name,'mailto:'.$email,array('target'=>'_blank'))?> has a suggestion/comment which is listed below:
<br/><br/>
<?php echo $body?>
<br/><br/>
----<br/>
Regards
<br/>
<?php echo CHtml::encode(Yii::app()->name)?> team