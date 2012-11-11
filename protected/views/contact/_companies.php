<?php
/* @var $this ContactController */
/* @var $companies Company[] */
?>

<?php
echo "<h4>".CHtml::link('My Companies','javascript:updateDivs();')."</h4>";
echo "<ul>";
foreach($companies as $it){
    echo "<li>".CHtml::link($it->name,'javascript:updateDivs('.$it->id.');')."</li>";
}
echo "</ul>";
?>