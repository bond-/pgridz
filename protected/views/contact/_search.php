<?php
/* @var $this ContactController */
/* @var $model Contact */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'company_id'); ?>
		<?php echo $form->textField($model,'company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'group_division'); ?>
		<?php echo $form->textField($model,'group_division',array('maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'school'); ?>
		<?php echo $form->textField($model,'school',array('maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'questions_to_ask'); ?>
		<?php echo $form->textArea($model,'questions_to_ask',array('rows'=>6, 'cols'=>50)); ?>
	</div>

    <div class="row">
        <?php echo $form->label($model,'iq'); ?>
        <?php echo $form->radioButtonList($model,'iq',array(
                0=>'Brain dead',
                1=>'Bumbling bear',
                2=>'Average',
                3=>'Smarty pants',
                4=>'Einstein',
            ),array('separator'=>" "))?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'like'); ?>
        <?php echo $form->radioButtonList($model,'like',array(
                0=>'Drive me nuts',
                1=>'Ok',
                2=>'Hi',
                3=>'Smooch',
                4=>'Love you',
            ),array('separator'=>" "))?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->