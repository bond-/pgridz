<?php
/* @var $forgotPasswordForm ForgotPasswordForm */
/* @var $form TbActiveForm  */
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'forgotPasswordModal','events'=>array('hidden'=>'js:resetForgotPasswordForm'))); ?>
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
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        jQuery.validator.setDefaults({
            errorElement: "div"
        });
        validateForgotPasswordForm();
    });
    //validate User registration form
    function validateForgotPasswordForm(){
        jQuery.validator.addMethod(
                "userNotExists",
                function(value, element) {
                    var condition = false;
                    $.ajax('<?php echo $this->createUrl('user/exists')?>',{
                        async:false,
                        data:{email:value},
                        success:function(){condition=false;},
                        error:function(data){condition=true;}
                    });
                    return !condition;
                },
                "No user exists with this email"
        );
        $("#forgot-password-form").validate({
            onkeyup: false,
            rules: {
                'ForgotPasswordForm[email]': {
                    required: true,
                    email: true,
                    userNotExists: true
                }
            },
            messages: {
                'ForgotPasswordForm[email]':{
                    required: "Email is required"
                }
            }
        })
    }
    //Sends an ajax post request to controller
    function sendEmailForPasswordResetJS()
    {
        var fpForm = $("#forgot-password-form");
        if(fpForm.validate().form()){
            var data=$(fpForm).serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("user/forgotPassword"); ?>',
                data:data,
                beforeSend:function(){showLoading();resetForgotPasswordForm();},
                success:function(data){
                    hideLoading();
                    jQuery.notify("An email is sent to your email address to reset your password", "success", {timeout: 0});
                },
                error: function(data) { // if error occured
                    hideLoading();
                    if(data.status==500){
                        jQuery.notify("User doesn't exit", "error", {timeout: 5});
                    }else if(data.status==503){
                        jQuery.notify("Unable to update password..!! Please try again.", "error", {timeout: 5});
                    }else{
                        jQuery.notify("Unable to update password..!! Please try again.", "error", {timeout: 5});
                    }
                }
            });
        }
    }
    function resetForgotPasswordForm(){
        $("#forgot-password-close").click();
        var fpForm = $("#forgot-password-form");
        fpForm.trigger("reset");
        fpForm.validate().resetForm();
        fpForm.find("input").removeClass('error');
    }
</script>