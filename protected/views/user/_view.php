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
        <div class="btn-toolbar" style="margin-left: 100px">
            <?php
            $this->widget('bootstrap.widgets.TbButton',
                array(
                    'buttonType'=>'button',
                    'type'=>'primary',
                    'label'=>'Edit contact',
                    'icon'=>'icon-pencil icon-white',
                    'htmlOptions'=>array(
                        'onclick'=> 'renderEditProfileJS()',
                    ))
            ); ?>
        </div>
</div>
