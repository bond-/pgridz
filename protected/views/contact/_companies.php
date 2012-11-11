<?php
/* @var $this ContactController */
/* @var $companies Company[] */
?>

<?php
echo "<h4>".CHtml::link('My Companies','#',array('onclick'=>'updateDivs()'))."</h4>";
foreach($companies as $it){
    echo "<li>".CHtml::link($it->name,'#',array('onclick'=>'updateDivs('.$it->id.')'))."</li>";
}
?>