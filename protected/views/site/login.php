<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form TbActiveForm  */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'login-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->textFieldRow($model,'email'); ?>

<?php echo $form->passwordFieldRow($model,'password'); ?>

<?php echo $form->checkBoxRow($model,'rememberMe'); ?>
<div class="btn-toolbar">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Login', 'type'=>'primary', 'size'=>'normal')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('label'=>'Register','type'=>'primary','buttonType'=>'link','size'=>'normal','url'=>$this->createUrl('user/register'),)); ?>
</div>
<?php $this->endWidget(); ?>
