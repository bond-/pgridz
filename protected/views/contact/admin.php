<?php
/* @var $this ContactController */
/* @var $model Contact */

$this->breadcrumbs=array(
	'Contacts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Contact', 'url'=>array('index')),
	array('label'=>'Create Contact', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('contact-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Contacts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contact-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'title',
		'group_division',
		/*
		'city',
		'country',
		'phone',
		'email',
		'school',
		'notes',
		'questions_to_ask',
		'iq',
		'like',
		*/
		array(
			'class'=>'CButtonColumn',
            'buttons'=>array
            (
                'view'=>array
                (
                    'url'=>'Yii::app()->createUrl("contact/view", array("id"=>$data->id))',
                ),
                'update'=>array
                (
                    'url'=>'Yii::app()->createUrl("contact/update", array("id"=>$data->id))',
                ),
                'delete'=>array
                (
                    'url'=>'Yii::app()->createUrl("contact/delete", array("id"=>$data->id))',
                ),
            )
		),
	),
)); ?>
