<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $newUser User */
/* @var $forgotPasswordForm ForgotPasswordForm*/
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

<?php echo $form->textFieldRow($model,'email',array('class'=>'span12')); ?>

<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span12')); ?>

<?php echo $form->checkBoxRow($model,'rememberMe'); ?>
<div class="btn-toolbar">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Login', 'type'=>'primary', 'size'=>'small')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Forgot password',
    'type'=>'primary',
    'size'=>'small',
    'htmlOptions'=>array(
        'data-toggle'=>'modal',
        'data-target'=>'#forgotPasswordModal',
        'onclick'=> '$("#forgot-password-form").trigger("reset")',
    ),));
    ?>
    )); ?>
</div>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('_registration', array('newUser'=>$newUser)); ?>
<?php echo $this->renderPartial('_forgotPassword', array('forgotPasswordForm'=>$forgotPasswordForm)); ?>
<style type="text/css">
    .error{
        color: #990000;
    }
</style>