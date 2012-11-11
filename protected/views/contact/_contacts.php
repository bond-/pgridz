<?php
/* @var $this ContactController */
/* @var $contacts Contact[] */
?>
<h4>My Contacts</h4>
<ul>
    <?php
    foreach($contacts as $it){
        echo "<li>".CHtml::link($it->name,$this->createUrl('/contact/view',array('id'=>$it->id)))."</li>";
    }
    ?>
</ul>