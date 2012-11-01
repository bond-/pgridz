<?php
/* @var $this ContactController */
/* @var $model Contact */
/* @var $companies Company[] */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
        <?php echo $form->dropDownList($model, 'company_id', CHtml::listData($companies,'id','name'), array('empty'=>'Select a company')); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group_division'); ?>
		<?php echo $form->textField($model,'group_division',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'group_division'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'school'); ?>
		<?php echo $form->textField($model,'school',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'school'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'questions_to_ask'); ?>
		<?php echo $form->textArea($model,'questions_to_ask',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'questions_to_ask'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'iq'); ?>
        <?php /*$this->widget('zii.widgets.jui.CJuiSliderInput', array(
            'model'=>$model,
            'attribute'=>'iq',
            // additional javascript options for the slider plugin
            'options'=>array(
                'min'=>0,
                'max'=>4,
                'step'=>1,
            ),
            'htmlOptions'=>array(
                'style'=>'width:100px;top:5px;bottom:5px;'
            ),
        )); */?>
        <?php echo $form->radioButtonList($model,'iq',array(
        0=>'Brain dead',
        1=>'Bumbling bear',
        2=>'Average',
        3=>'Smarty pants',
        4=>'Einstein',
    ),array('separator'=>" | "))?>
		<?php echo $form->textField($model,'iq'); ?>
		<?php echo $form->error($model,'iq'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'like'); ?>
		<?php echo $form->textField($model,'like',array('placeholder'=>$model->getAttributeLabel('like'))); ?>
		<?php echo $form->error($model,'like'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->