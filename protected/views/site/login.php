<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $newUser User */
/* @var $forgotPasswordForm ForgotPasswordForm*/
/* @var $form TbActiveForm  */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'login-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->textFieldRow($model,'email'); ?>

<?php echo $form->passwordFieldRow($model,'password'); ?>

<?php echo $form->checkBoxRow($model,'rememberMe'); ?>
<div class="btn-toolbar">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Login', 'type'=>'primary', 'size'=>'normal')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Forgot password',
    'type'=>'primary',
    'htmlOptions'=>array(
        'data-toggle'=>'modal',
        'data-target'=>'#forgotPasswordModal',
        'onclick'=> '$("#forgot-password-form").trigger("reset")',
    ),));
    ?>
    )); ?>
</div>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'forgotPasswordModal')); ?>
<div class="modal-header">
    <a class="close" id ="forgot-password-close" data-dismiss="modal">&times;</a>
    <h4>Forgot password..??</h4>
</div>
<div class="modal-body">
    <div class="form">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'forgot-password-form',
        'type'=>'horizontal',
        'enableClientValidation'=>false,
        'focus'=>array($forgotPasswordForm,'email'),
        'htmlOptions'=>array('class'=>'well'),
    )); ?>
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->textFieldRow($forgotPasswordForm,'email',array('size'=>60,'maxlength'=>255)); ?>
        <div class="btn-toolbar">
            <?php $this->widget('bootstrap.widgets.TbButton',
            array(
                'buttonType'=>'button',
                'type'=>'primary',
                'label'=>'Submit',
                'htmlOptions'=>array(
                    'onClick'=> 'sendEmailForPasswordResetJS()',
                ))
        );?>
    )
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

<!--Registration block-->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'userRegistrationModal')); ?>
<div class="modal-header">
    <a class="close" id ="register-close" data-dismiss="modal">&times;</a>
    <h4>Registration</h4>
</div>

<div class="modal-body">
    <div class="form">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'user-form',
        'type'=>'horizontal',
        'enableClientValidation'=>false,
        'focus'=>array($newUser,'email'),
        'htmlOptions'=>array('class'=>'well'),
    )); ?>
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->textFieldRow($newUser,'email',array('size'=>60,'maxlength'=>255,'class'=>'required')); ?>
        <!--<div for="RegistrationForm_email" generated="true"></div>-->
        <?php echo $form->passwordFieldRow($newUser,'password',array('size'=>60,'maxlength'=>255,'class'=>'required')); ?>
        <!--<div for="RegistrationForm_password" generated="true"></div>-->
        <?php echo $form->passwordFieldRow($newUser,'password2',array('size'=>60,'maxlength'=>255,'class'=>'required')); ?>
        <!--<div for="RegistrationForm_password2" generated="true"></div>-->
        <div class="btn-toolbar">
            <?php $this->widget('bootstrap.widgets.TbButton',
            array(
                'buttonType'=>'button',
                'type'=>'primary',
                'label'=>'Submit',
                'htmlOptions'=>array(
                    'onClick'=> 'createProfileJS()',
                    ))
                );
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<!-- form -->
<?php $this->endWidget(); ?>
<style type="text/css">
    .error{
        color: #990000;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        jQuery.validator.setDefaults({
            errorElement: "div"
        });
        validateRegistrationForm();
        validateForgotPasswordForm();
    });
    //validate User registration form
    function validateRegistrationForm(){
        jQuery.validator.addMethod(
                "reenterPassword",
                function(value, element) {
                    return $('#RegistrationForm_password').val()==value;
                },
                "Password 2 doesn't match with password"
        );
        $("#user-form").validate({
            rules: {
                'RegistrationForm[email]': {
                    required: true
                },
                'RegistrationForm[password]': {
                    required: true
                },
                'RegistrationForm[password2]': {
                    required: true,
                    reenterPassword:true
                }
            },
            messages: {
                'RegistrationForm[email]':{
                    required: "Email is required"
                },
                'RegistrationForm[password]': {
                    required: "Password is required"
                },
                'RegistrationForm[password2]': {
                    required: "Password 2 is required"
                }
            }
        })
    }
    function createProfileJS()
    {
        if($("#user-form").validate().form()){
            var data=$("#user-form").serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("user/register"); ?>',
                data:data,
                success:function(data){
                    $("#register-close").click();
                    jQuery.notify("Congratulations..!! You have successfully registered. Please verify email.", "success", {timeout: 0});
                },
                error: function(data) { // if error occured
                    jQuery.notify("Unable to create a new account..!! Please try again.", "error", {timeout: 5});
                }
            });
            $("#user-form").trigger("reset");
        }

    }
    //validate User registration form
    function validateForgotPasswordForm(){
        $("#forgot-password-form").validate({
            rules: {
                'ForgotPasswordForm[email]': {
                    required: true
                }
            },
            messages: {
                'ForgotPasswordForm[email]':{
                    required: "Email is required"
                }
            }
        })
    }
    function sendEmailForPasswordResetJS()
    {
        var formFP = $("#forgot-password-form");
        if($("#forgot-password-form").validate().form()){
            var data=$(formFP).serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("user/forgotPassword"); ?>',
                data:data,
                success:function(data){
                    jQuery.notify("An email is sent to your email address to reset your password", "success", {timeout: 0});
                },
                error: function(data) { // if error occured
                    if(data.status==500){
                        jQuery.notify("User doesn't exit", "error", {timeout: 5});
                    }else{
                        jQuery.notify("Unable to update password..!! Please try again.", "error", {timeout: 5});
                    }

                }
            });
            $("#forgot-password-close").click();
            $("#user-form").trigger("reset");
        }

    }
</script>