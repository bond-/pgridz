<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mj
 * Date: 10/11/12
 * Time: 5:01 PM
 * To change this template use File | Settings | File Templates.
 */

?>
Hi,
<br/><br/>
You (or someone pretending to be you) created an account with this email address.
<br/><br/>
If you made the request, please click the following link to finish the registration:<?php echo $link?>
<br/><br/>
To login please visit: <a href="<?php echo Yii::app()->createAbsoluteUrl("");?>"><?php echo CHtml::encode(Yii::app()->name)?></a>
<br/><br/><br/>

----<br/>
Regards
<br/>
<?php echo CHtml::encode(Yii::app()->name)?> team


