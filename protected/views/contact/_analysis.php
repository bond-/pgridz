<?php
/* @var $this ContactController */
/* @var $analysis array */
?>
<h4>Analysis</h4>
<ul>
    <?php
    $smartestAttrs = array();
    $likableAttrs = array();
    $comboAttrs = array();
    if(isset($analysis['id'])){
        $smartestAttrs['id'] = $analysis['id'];
        $likableAttrs['id'] = $analysis['id'];
        $comboAttrs['id'] = $analysis['id'];
    }

    $smartestAttrs['sort'] = $analysis['smartest']['sort'];
    $smartestAttrs['order'] = $analysis['smartest']['order'];
    $likableAttrs['sort'] = $analysis['likable']['sort'];
    $likableAttrs['order'] = $analysis['likable']['order'];
    $comboAttrs['sort'] = $analysis['combo']['sort'];
    $comboAttrs['order'] = $analysis['combo']['order'];
    echo '<li>'.CHtml::link('Smartest',$this->createUrl('contact/export',$smartestAttrs)).'</li>'.
    '<li>'.CHtml::link('Most likable',$this->createUrl('contact/export',$likableAttrs)).'</li>'.
    '<li>'.CHtml::link('Combo',$this->createUrl('contact/export',$comboAttrs)).'</li>';
    ?>
</ul>