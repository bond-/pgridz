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
<div id='contact-view' class="row-fluid span9">
    <div class="span5">
        <h3><?php echo $model->company->name.': '.$model->name; ?></h3>
    </div>
    <div class="span5 pull-right">
        <div class="btn-toolbar pull-right">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Edit Contact',
            'type'=>'primary',
            'size'=>'normal',
            'url'=>$this->createUrl('/contact/update',array('id'=>$_GET['id'])),
            'buttonType'=>'ajaxButton',
            'icon'=>'icon-pencil icon-white',
            'ajaxOptions'=>array('update'=>'body'),
        )); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Delete',
            'type'=>'danger',
            'size'=>'normal',
            'url'=>$this->createUrl('/contact/delete'),
            'buttonType'=>'ajaxButton',
            'icon'=>'icon-trash icon-white',
            'ajaxOptions'=>array(
                'type'=>'post',
                'data'=>array('id'=>$_GET['id']),
                'beforeSend'=>'js:function(xhr,opts){
                    if(!confirm("Are you sure?")){
                        xhr.abort();
                    }
                }',
                'success'=>'js:function(){
                    $.notify("Contact delete successfully, please wait while we redirect you","success");
                    setTimeout(function(){window.location = "'.$this->createUrl('/contact/index').'"},2000);
                }'
            ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <?php $this->widget('bootstrap.widgets.TbDetailView', array(
            'data'=>$model,
            'type'=>'striped bordered condensed',
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
        </div>
    </div>
</div>