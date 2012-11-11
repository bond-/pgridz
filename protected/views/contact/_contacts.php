<?php
/* @var $this ContactController */
/* @var $contacts Contact[] */

echo "<h4>".CHtml::link('My Contacts','javascript:updateDivs(); ')."</h4>";
?>
<ul>
    <?php
    foreach($contacts as $it){
        echo "<li>".CHtml::link($it->name,$this->createUrl('/contact/view',array('id'=>$it->id)))."</li>";
    }
    ?>
</ul>