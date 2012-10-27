<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'My Profile'
);

$this->menu=array(
	array('label'=>'Update Profile', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Update Password', 'url'=>array('updatePassword')),
);
?>

<h1>My Profile</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'email',
		'city_id',
		'state_id',
		'country_id',
		'zip',
		'join_date',
		'end_date',
	),
)); ?>
