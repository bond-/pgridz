<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $forgotPasswordForm ForgotPasswordForm */
/* @var $newUser RegistrationForm */

$this->pageTitle=Yii::app()->name;
?>

<div class="row-fluid">
    <div class="span9">
        <div class="hero-unit">
            <h3>Network like a Professional. For FREE!</h3>
            <ul>
                <li>Keep track of all your important contacts and access them from anywhere.</li>
                <li>Add detailed notes, tags and sort by contacts and companies.</li>
                <li>Print your company notes to help remember details during BankWeeks, on-campus visit sessions etc.</li>
                <li>Many more features coming soon! <?php echo CHtml::link('Suggest new features to better serve your needs.',array('/site/contact'),array('target'=>'_blank'));?></li>
            </ul>
            <br/><br/>
            <?php echo "New to Pgridz? "?>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Create account',
            'type'=>'info',
            'htmlOptions'=>array(
                'data-toggle'=>'modal',
                'data-target'=>'#userRegistrationModal',
                'onclick'=> '$("#user-form").trigger("reset")',
            ),));
            ?>
        </div>
    </div>
    <div class="span3">
        <?php $this->renderPartial('login',array('model'=>$model,'newUser'=>$newUser,'forgotPasswordForm'=>$forgotPasswordForm)); ?>
    </div>
</div>