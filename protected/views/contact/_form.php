<?php
/* @var $this ContactController */
/* @var $model Contact */
/* @var $companies Company[] */
/* @var $form TbActiveForm */
?>

<div class="span12">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'contact-form',
    'type'=>'horizontal',
    'action'=>array('contact/update&id='.$_GET['id']),
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'afterValidate' => 'js:afterValidate',
    ),
    'htmlOptions'=>array('class'=>'well')
)); ?>

    <p class="text-info">Fields with <span class="required">*</span> are required.</p>
    <div class="control-group">
        <label class="control-label required" for="Company[name]"><?php echo CHtml::encode($company->getAttributeLabel('name'))?> <span class="required">*</span></label>
        <div class="controls">
            <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
            'model'=>$company,'attribute'=>'name','htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),
            'options'=>array(
                'name'=>'typeahead',
                'source'=>'js:function(query,callback){$.ajax("'.$this->createUrl('/company/list').'",{data:{name:query},success:function(data){callback(JSON.parse(data));},error:function(){callback([]);}});}',
                'matcher'=>"js:function(item) {return ~item.toLowerCase().indexOf(this.query.toLowerCase());}",
            ),
        )); ?>
            <?php echo $form->error($company,'name'); ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($contact,'name',array('maxlength'=>255,'class'=>'span12')); ?>

    <div class="control-group">
        <label class="control-label" for="Contact[title]"><?php echo CHtml::encode($contact->getAttributeLabel('title'))?></label>
        <div class="controls">
            <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
            'model'=>$contact,'attribute'=>'title','htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),
            'options'=>array(
                'name'=>'typeahead',
                'source'=>'js:function(query,callback){$.ajax("'.$this->createUrl('/contact/list').'",{data:{query:query,field:"title"},success:function(data){callback(JSON.parse(data));},error:function(){callback([]);}});}',
                'matcher'=>"js:function(item) {return ~item.toLowerCase().indexOf(this.query.toLowerCase());}",
            ),
        )); ?>
            <?php echo $form->error($company,'title'); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="Contact[group_division]"><?php echo CHtml::encode($contact->getAttributeLabel('group_division'))?></label>
        <div class="controls">
            <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
            'model'=>$contact,'attribute'=>'group_division','htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),
            'options'=>array(
                'name'=>'typeahead',
                'source'=>'js:function(query,callback){$.ajax("'.$this->createUrl('/contact/list').'",{data:{query:query,field:"group_division"},success:function(data){callback(JSON.parse(data));},error:function(){callback([]);}});}',
                'matcher'=>"js:function(item) {return ~item.toLowerCase().indexOf(this.query.toLowerCase());}",
            ),
        )); ?>
            <?php echo $form->error($contact,'group_division'); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="Contact[city]"><?php echo CHtml::encode($contact->getAttributeLabel('city'))?></label>
        <div class="controls">
            <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
            'model'=>$contact,'attribute'=>'city','htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),
            'options'=>array(
                'name'=>'typeahead',
                'source'=>'js:function(query,callback){$.ajax("'.$this->createUrl('/contact/list').'",{data:{query:query,field:"city"},success:function(data){callback(JSON.parse(data));},error:function(){callback([]);}});}',
                'matcher'=>"js:function(item) {return ~item.toLowerCase().indexOf(this.query.toLowerCase());}",
            ),
        )); ?>
            <?php echo $form->error($contact,'city'); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="Contact[country]"><?php echo CHtml::encode($contact->getAttributeLabel('country'))?></label>
        <div class="controls">
            <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
            'model'=>$contact,'attribute'=>'country','htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),
            'options'=>array(
                'name'=>'typeahead',
                'source'=>'js:function(query,callback){$.ajax("'.$this->createUrl('/contact/list').'",{data:{query:query,field:"country"},success:function(data){callback(JSON.parse(data));},error:function(){callback([]);}});}',
                'matcher'=>"js:function(item) {return ~item.toLowerCase().indexOf(this.query.toLowerCase());}",
            ),
        )); ?>
            <?php echo $form->error($contact,'country'); ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($contact,'phone',array('maxlength'=>255,'class'=>'span12')); ?>
    <?php echo $form->textFieldRow($contact,'email',array('maxlength'=>255,'class'=>'span12')); ?>

    <div class="control-group">
        <label class="control-label" for="Contact[school]"><?php echo CHtml::encode($contact->getAttributeLabel('school'))?></label>
        <div class="controls">
            <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
            'model'=>$contact,'attribute'=>'school','htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),
            'options'=>array(
                'name'=>'typeahead',
                'source'=>'js:function(query,callback){$.ajax("'.$this->createUrl('/contact/list').'",{data:{query:query,field:"school"},success:function(data){callback(JSON.parse(data));},error:function(){callback([]);}});}',
                'matcher'=>"js:function(item) {return ~item.toLowerCase().indexOf(this.query.toLowerCase());}",
            ),
        )); ?>
            <?php echo $form->error($contact,'school'); ?>
        </div>
    </div>
    <?php echo $form->textAreaRow($contact,'notes',array('rows'=>6, 'cols'=>50,'class'=>'span12')); ?>
    <?php echo $form->textAreaRow($contact,'questions_to_ask',array('rows'=>6, 'cols'=>50,'class'=>'span12')); ?>
    <?php echo $form->radioButtonListInlineRow($contact,'iq',array(
    0=>'Brain dead',
    1=>'Bumbling bear',
    2=>'Average',
    3=>'Smarty pants',
    4=>'Einstein',
),array('separator'=>"",'class'=>'input-medium'))?>
    <?php echo $form->radioButtonListInlineRow($contact,'c_like',array(
    0=>'Drive me nuts',
    1=>'Ok',
    2=>'Hi',
    3=>'Smooch',
    4=>'Love you',
),array('separator'=>"",'class'=>'input-medium'))?>

    <div class="btn-toolbar ">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'label'=>'Save',
        'type'=>'primary',
        'size'=>'normal',
    )); ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    function afterValidate(form, data, hasError){
        if (!hasError) {
            var _form = $(form);
            $.ajax({
                url: _form.attr('action'),
                type: 'POST',
                dataType: 'json',
                data:_form.serialize()
            })
                    .done(function ( response ) {
                        _form.trigger('reset');
                        $.notify("You have successfully updated the contact","success");
                        window.location = "<?php echo $this->createAbsoluteUrl('/contact/view',array('id'=>$_GET['id']));?>";
                    })
                    .fail(function ( xhr, status ) {
                        $.notify("Updating the contact failed","error");
                    });
            return false;
        }
    }
</script>