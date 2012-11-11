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
You (or someone pretending to be you) requested that your password be reset.
<br/><br/>
If you didn't make this request then ignore the email, no changes have been made.
<br/><br/>
If you did make the request, then click the following link to have your password reset and mailed to you: <?php echo $link?>
<br/><br/>

<br/><br/>
----<br/>
Regards<br/>

<?php echo CHtml::encode(Yii::app()->name)?> team




