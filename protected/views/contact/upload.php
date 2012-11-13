<?php
    /* @var $this ContactController */
    /* @var $model UploadForm */
    /* @var $form TbActiveForm*/

    $this->breadcrumbs=array(
        'Contacts'=>array('index'),
        'Upload',
    );
?>

<div class="row-fluid">
    <div class="span7">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'upload-form',
        'type'=>'horizontal',
        'enableClientValidation'=>false,
        'htmlOptions'=>array('class'=>'well','enctype' => 'multipart/form-data')
    )); ?>
        <p class="text-info">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->fileFieldRow($model,'file',array('id'=>'file','class'=>'span12','title'=>'Supported formats: xls,xlsx,ods')); ?>
        <div class="btn-toolbar ">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'label'=>'Upload',
            'icon'=>'icon-upload icon-white',
            'type'=>'primary',
            'size'=>'normal',
        )); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'link',
            'url'=>Yii::app()->baseUrl.'/sample/upload_contacts.xls',
            'label'=>'Download sample',
            'icon'=>'icon-file icon-white',
            'type'=>'primary',
            'size'=>'normal',
        )); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <?php if(isset($errors) && !empty($errors)) :?>
    <div class="span5 well text-error">
        <h4>Errors in upload</h4>
        <?php
        echo '<ul>';
        foreach($errors as $error){
            echo '<li>'.$error.'</li>';
        }
        echo '</ul>';
        ?>
    </div>
    <?php endif;?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#file').tooltip();
        // validate the comment form when it is submitted
        $("#upload-form").validate({
            rules: {
                'UploadForm[file]':{
                    required:true,
                    extension:'xls|xlsx|ods'
                }
            },
            messages: {
                'UploadForm[file]':{
                    required:"This field is required",
                    extension:'File type not supported, Accepted types: xls|xlsx|odt'
                }
            }
        });
    });
</script>
