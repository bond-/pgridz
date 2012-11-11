<?php
/* @var $this ContactController */
/* @var $companies Company[] */
?>

<h4>My Companies</h4>
<?php
foreach($companies as $it){
    echo "<li>".CHtml::link($it->name,'#',array('onclick'=>'updateDivs('.$it->id.')'))."</li>";
}
?>