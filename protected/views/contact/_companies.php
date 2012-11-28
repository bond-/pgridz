<?php
/* @var $this ContactController */
/* @var $companies Company[] */
?>

<?php
if(isset($title)){
    echo "<h4>".CHtml::link('My Companies <i class="icon-arrow-up"></i>','javascript:updateDivs();',array('title'=>'Back to all contacts'))."</h4>";
}else{
    echo "<h4>My Companies</h4>";
}
echo "<ul>";
if(sizeof($companies)>1){
    foreach($companies as $it){
        echo "<li>".CHtml::link($it->name,'javascript:updateDivs('.$it->id.');')."</li>";
    }
}else{
    echo "<li>".$companies[0]->name."</li>";
}
echo "</ul>";
?>