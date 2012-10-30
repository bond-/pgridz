<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
    'My Profile'=>array('view'),
	'Update',
);

$this->menu=array(
	array('label'=>'View Profile', 'url'=>array('view')),
	array('label'=>'Update Password', 'url'=>array('updatePassword')),
);
?>

<h1>My Profile</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>