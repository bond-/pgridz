<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array('class'=>'well'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->textFieldRow($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>

		<?php echo $form->passwordFieldRow($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>

		<?php echo $form->checkBoxRow($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Login', 'type'=>'primary', 'size'=>'normal')); ?>
<?php $this->endWidget(); ?>
