<?php
/* @var $this ContactController */
/* @var $data Contact */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->company->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->company->name); ?>
    <br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group_division')); ?>:</b>
	<?php echo CHtml::encode($data->group_division); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('country')); ?>:</b>
	<?php echo CHtml::encode($data->country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('school')); ?>:</b>
	<?php echo CHtml::encode($data->school); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('questions_to_ask')); ?>:</b>
	<?php echo CHtml::encode($data->questions_to_ask); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iq')); ?>:</b>
	<?php echo CHtml::encode($data->iq); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('like')); ?>:</b>
	<?php echo CHtml::encode($data->like); ?>
	<br />

	*/ ?>

</div>