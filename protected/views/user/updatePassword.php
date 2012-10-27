<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
    'My Profile'=>array('view','id'=>Yii::app()->user->id),
    'Update password'
);
?>

<h1>Update password</h1>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'update-password-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'newPassword1'); ?>
        <?php echo $form->passwordField($model,'newPassword1'); ?>
        <?php echo $form->error($model,'newPassword1'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'newPassword2'); ?>
        <?php echo $form->passwordField($model,'newPassword2'); ?>
        <?php echo $form->error($model,'newPassword2'); ?>
    </div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Update'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
