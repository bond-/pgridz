<?php
/* @var $newUser User */
/* @var $form TbActiveForm  */
?>

<!--Registration block-->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'userRegistrationModal','events'=>array('hidden'=>'js:resetRegistrationForm'))); ?>
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
        <?php echo $form->passwordFieldRow($newUser,'password',array('size'=>60,'maxlength'=>255,'class'=>'required')); ?>
        <?php echo $form->passwordFieldRow($newUser,'password2',array('size'=>60,'maxlength'=>255,'class'=>'required')); ?>
        <div class="btn-toolbar">
            <?php $this->widget('bootstrap.widgets.TbButton',
            array(
                'buttonType'=>'button',
                'type'=>'primary',
                'label'=>'Submit',
                'htmlOptions'=>array(
                    'onClick'=> 'createProfileJS()',
                    'style'=>'margin-left:200px'
                ))
        );?>
        <?php
            $this->widget('bootstrap.widgets.TbButton',
                array(
                    'buttonType'=>'button',
                    'type'=>'danger',
                    'label'=>'Cancel',
                    'htmlOptions'=>array(
                    'onClick'=> 'resetRegistrationForm()',
                ))
            ); ?>
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
        jQuery.validator.addMethod(
                "userExists",
                function(value, element) {
                    var condition = false;
                    $.ajax('<?php echo $this->createUrl('user/exists')?>',{
                        async:false,
                        data:{email:value},
                        success:function(){condition=false;},
                        error:function(data){condition=true;}
                    });
                    return condition;
                },
                "A user already exists with this email"
        );
        $("#user-form").validate({
            onkeyup: false,
            rules: {
                'RegistrationForm[email]': {
                    required: true,
                    email:true,
                    userExists:true
                },
                'RegistrationForm[password]': {
                    required: true,
                    minlength:6
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
                    required: "Password is required",
                    minlength:"Password length must be 6 characters"
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
                beforeSend:function(){showLoading();resetRegistrationForm();},
                success:function(data){
                    hideLoading();
                    jQuery.notify("Congratulations..!! You have successfully registered. Please verify email.", "success", {timeout: 0});
                },
                error: function(data) { // if error occured
                    hideLoading();
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
        var userForm = $('#user-form');
        userForm.trigger("reset");
        userForm.validate().resetForm();
        userForm.find("input").removeClass('error');
    }
</script>