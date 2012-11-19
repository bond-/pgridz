<?php
/* @var $this ContactController */
/* @var $contact Contact */
/* @var $company Company */

$this->breadcrumbs=array(
	'Contacts'=>array('index'),
	$contact->name=>array('view','id'=>$contact->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Contact', 'url'=>array('index')),
	array('label'=>'Create Contact', 'url'=>array('create')),
	array('label'=>'View Contact', 'url'=>array('view', 'id'=>$contact->id)),
	array('label'=>'Manage Contact', 'url'=>array('admin')),
);
?>
<div class="row-fluid span9">
    <div class="row-fluid">
        <div class="span12">
            <h3><?php echo $contact->company->name.': '.$contact->name; ?></h3>
        </div>
    </div>
    <div class="row-fluid">
        <?php echo $this->renderPartial('_form', array('contact'=>$contact,'company'=>$company,)); ?>
    </div>
</div>