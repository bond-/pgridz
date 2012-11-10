<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::app()->name . ' - Suggestion/Comment';
$this->breadcrumbs=array(
    'Suggestion/Comment',
);
?>

<h1>Contact Us</h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>
    If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
</p>
<div class="row-fluid">
    <div class="span12">
        <div class="form">

            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id'=>'contact-form',
            'type'=>'horizontal',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions'=>array('class'=>'well'),
        )); ?>
            <p class="note">Fields with <span class="required">*</span> are required.</p>
            <?php echo $form->textFieldRow($model,'name'); ?>
            <?php echo $form->textFieldRow($model,'email'); ?>
            <?php echo $form->textFieldRow($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
            <?php echo $form->textAreaRow($model,'body',array('rows'=>6, 'cols'=>50)); ?>
            <?php if(CCaptcha::checkRequirements()): ?>
            <div>
                <?php echo $form->captchaRow($model,'verifyCode',array('hint'=>'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.')); ?>
            </div>
            <?php endif; ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Submit', 'type'=>'primary', 'size'=>'large','htmlOptions'=>array('style'=>'margin-left:180px'))); ?>
            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div>
<?php endif; ?>