<?php
/* @var $this ContactController */
/* @var $contacts Contact[] */
if(isset($title)){
    echo "<h4>".CHtml::link($title.' <i class="icon-arrow-up"></i>','javascript:updateDivs();',array('title'=>'Back to all contacts'))."</h4>";
}else{
    echo "<h4>My Contacts</h4>";
}
?>
<ul>
    <?php
    foreach($contacts as $it){
        echo "<li>".CHtml::link($it->name,$this->createUrl('/contact/view',array('id'=>$it->id)))."</li>";
    }
    ?>
</ul>