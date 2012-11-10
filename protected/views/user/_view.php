<?php
/* @var $this UserController */
/* @var $profileForm User */
?>
<div id="viewProfile">
    <fieldset>
        <legend><?php echo CHtml::encode($tabHeader); ?></legend>
        <?php $this->widget('bootstrap.widgets.TbDetailView', array(
        'data'=>$profileForm,
        'attributes'=>array(
            'email',
            'city',
            'state',
            'country',
            'zip',
        ),
    )); ?>
    </fieldset>
</div>