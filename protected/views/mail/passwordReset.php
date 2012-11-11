<?php
?>
Hi,
<br/><br/>
Your password has been reset to following text. Please update once login into system.
<br/><br/>
<b><?php echo $password?></b>
<br/><br/>
To login please visit: <a href="<?php echo Yii::app()->createAbsoluteUrl("");?>"><?php echo CHtml::encode(Yii::app()->name)?></a>
<br/><br/><br/>

----<br/>
Regards
<br/>
<?php echo CHtml::encode(Yii::app()->name)?> team


