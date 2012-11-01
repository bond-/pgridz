<?php
/* @var $this ContactController */
/* @var $model Contact */

$this->breadcrumbs=array(
	'Contacts'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Contact', 'url'=>array('index')),
	array('label'=>'Create Contact', 'url'=>array('create')),
	array('label'=>'Update Contact', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Contact', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Contact', 'url'=>array('admin')),
);
?>

<h1>View Contact: <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        array(
            'label'=>$model->company->getAttributeLabel('name'),
            'value'=>$model->company->name
        ),
		'name',
		'title',
		'group_division',
		'city',
		'country',
		'phone',
		'email',
		'school',
		'notes',
		'questions_to_ask',
        array(
            'label'=>$model->getAttributeLabel('iq'),
            'value'=>$model->getDisplayIqLabel($model->iq)
        ),
        array(
            'label'=>$model->getAttributeLabel('c_like'),
            'value'=>$model->getDisplayLikeLabel($model->c_like)
        ),
	),
)); ?>
