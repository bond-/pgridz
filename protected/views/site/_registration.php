<?php
/* @var $newUser User */
/* @var $form TbActiveForm  */
?>

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

<script type="text/javascript">
    $(document).ready(function() {
        jQuery.validator.setDefaults({
            errorElement: "div"
        });
        validateRegistrationForm();
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
    //Sends an ajax post request to controller
    function createProfileJS()
    {
        var userForm = $("#user-form");
        if(userForm.validate().form()){
            var data=userForm.serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("user/register"); ?>',
                data:data,
                beforeSend:resetRegistrationForm,
                success:function(data){
                    jQuery.notify("Congratulations..!! You have successfully registered. Please verify email.", "success", {timeout: 0});
                },
                error: function(data) { // if error occured
                    if(data.status==406){
                        jQuery.notify("User already exists", "error", {timeout: 0});
                    }else if(data.status==503){
                        jQuery.notify("Unable to send an email now. Please verify your email address by login", "error", {timeout: 0});
                    }else{
                        jQuery.notify("Unable to create a new account..!! Please try again.", "error", {timeout: 0});
                    }
                }
            });
        }
    }
    function resetRegistrationForm(){
        $("#register-close").click();
        $("#user-form").trigger("reset");
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
</script>