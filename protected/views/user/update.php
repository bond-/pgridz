<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
    'My Profile'=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'View Profile', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Update Password', 'url'=>array('updatePassword')),
);
?>

<h1>My Profile</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>