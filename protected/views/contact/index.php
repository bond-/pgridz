<?php
/* @var $this ContactController */
/* @var $dataProvider CActiveDataProvider */
/* @var $contact Contact */
/* @var $form TbActiveForm */
/* @var $company Company */
/* @var $contacts Contact[] */
/* @var $companies Company[] */

$this->breadcrumbs=array(
	'Contacts',
);
?>

<div class="row-fluid">
    <div class="span3">
        <div class="accordion-group">
            <div class="accordion" id="contact-accordion">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#contact-accordion" href="#contact-collapse">
                        <h4>Create Contact</h4>
                    </a>
                </div>
                <div id="contact-collapse" class="accordion-body collapse in">
                    <div class="accordion-inner">
                        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'id'=>'contact-form',
                        'enableAjaxValidation'=>true,
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                    )); ?>

                        <p class="text-info">Fields with <span class="required">*</span> are required.</p>
                        <label class="required" for="Company[name]"><?php echo CHtml::encode($company->getAttributeLabel('name'))?><span class="required">*</span></label>
                        <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
                        'model'=>$company,'attribute'=>'name','htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),
                        'options'=>array(
                            'name'=>'typeahead',
                            'source'=>'js:function(query,callback){$.ajax("'.$this->createUrl('/company/list').'",{data:{name:query},success:function(data){callback(JSON.parse(data));},error:function(){callback([]);}});}',
                            'matcher'=>"js:function(item) {return ~item.toLowerCase().indexOf(this.query.toLowerCase());}",
                        ),
                    )); ?>
                        <?php echo $form->textFieldRow($contact,'name',array('maxlength'=>255,'class'=>'span12')); ?>
                        <label class="required" for="Contact[title]"><?php echo CHtml::encode($contact->getAttributeLabel('title'))?></label>
                        <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
                        'model'=>$contact,'attribute'=>'title','htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),
                        'options'=>array(
                            'name'=>'typeahead',
                            'source'=>'js:function(query,callback){$.ajax("'.$this->createUrl('/contact/list').'",{data:{query:query,field:"title"},success:function(data){callback(JSON.parse(data));},error:function(){callback([]);}});}',
                            'matcher'=>"js:function(item) {return ~item.toLowerCase().indexOf(this.query.toLowerCase());}",
                        ),
                    )); ?>

                        <label class="required" for="Contact[group_division]"><?php echo CHtml::encode($contact->getAttributeLabel('group_division'))?></label>
                        <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
                        'model'=>$contact,'attribute'=>'group_division','htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),
                        'options'=>array(
                            'name'=>'typeahead',
                            'source'=>'js:function(query,callback){$.ajax("'.$this->createUrl('/contact/list').'",{data:{query:query,field:"group_division"},success:function(data){callback(JSON.parse(data));},error:function(){callback([]);}});}',
                            'matcher'=>"js:function(item) {return ~item.toLowerCase().indexOf(this.query.toLowerCase());}",
                        ),
                    )); ?>

                        <label class="required" for="Contact[city]"><?php echo CHtml::encode($contact->getAttributeLabel('city'))?></label>
                        <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
                        'model'=>$contact,'attribute'=>'city','htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),
                        'options'=>array(
                            'name'=>'typeahead',
                            'source'=>'js:function(query,callback){$.ajax("'.$this->createUrl('/contact/list').'",{data:{query:query,field:"city"},success:function(data){callback(JSON.parse(data));},error:function(){callback([]);}});}',
                            'matcher'=>"js:function(item) {return ~item.toLowerCase().indexOf(this.query.toLowerCase());}",
                        ),
                    )); ?>

                        <label class="required" for="Contact[country]"><?php echo CHtml::encode($contact->getAttributeLabel('country'))?></label>
                        <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
                        'model'=>$contact,'attribute'=>'country','htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),
                        'options'=>array(
                            'name'=>'typeahead',
                            'source'=>'js:function(query,callback){$.ajax("'.$this->createUrl('/contact/list').'",{data:{query:query,field:"country"},success:function(data){callback(JSON.parse(data));},error:function(){callback([]);}});}',
                            'matcher'=>"js:function(item) {return ~item.toLowerCase().indexOf(this.query.toLowerCase());}",
                        ),
                    )); ?>

                        <?php echo $form->textFieldRow($contact,'phone',array('maxlength'=>255,'class'=>'span12')); ?>
                        <?php echo $form->textFieldRow($contact,'email',array('maxlength'=>255,'class'=>'span12')); ?>
                        <label class="required" for="Contact[school]"><?php echo CHtml::encode($contact->getAttributeLabel('school'))?></label>
                        <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
                        'model'=>$contact,'attribute'=>'school','htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),
                        'options'=>array(
                            'name'=>'typeahead',
                            'source'=>'js:function(query,callback){$.ajax("'.$this->createUrl('/contact/list').'",{data:{query:query,field:"school"},success:function(data){callback(JSON.parse(data));},error:function(){callback([]);}});}',
                            'matcher'=>"js:function(item) {return ~item.toLowerCase().indexOf(this.query.toLowerCase());}",
                        ),
                    )); ?>
                        <?php echo $form->textAreaRow($contact,'notes',array('rows'=>6, 'cols'=>50,'class'=>'span12')); ?>
                        <?php echo $form->textAreaRow($contact,'questions_to_ask',array('rows'=>6, 'cols'=>50,'class'=>'span12')); ?>
                        <?php echo $form->radioButtonListRow($contact,'iq',array(
                        0=>'Brain dead',
                        1=>'Bumbling bear',
                        2=>'Average',
                        3=>'Smarty pants',
                        4=>'Einstein',
                    ),array('separator'=>"",'class'=>'input-medium'))?>
                        <?php echo $form->radioButtonListRow($contact,'c_like',array(
                        0=>'Drive me nuts',
                        1=>'Ok',
                        2=>'Hi',
                        3=>'Smooch',
                        4=>'Love you',
                    ),array('separator'=>"",'class'=>'input-medium'))?>

                        <div class="btn-toolbar "></div>
                        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Submit', 'type'=>'primary', 'size'=>'normal',)); ?>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="span3 well">
        <h4>My Contacts</h4>
        <ul>
            <?php
                foreach($contacts as $it){
                    echo "<li>".$it->name."</li>";
                }
            ?>
        </ul>
    </div>
    <div class="span3 well">
        <h4>My Companies</h4>
        <?php
        foreach($companies as $it){
            echo "<li>".$it->name."</li>";
        }
        ?>
    </div>
    <div class="span3 well">
        <h4>Analysis</h4>
    </div>
</div>
