<?php
/* @var $forgotPasswordForm ForgotPasswordForm */
/* @var $form TbActiveForm  */
?>

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
                beforeSend:resetForgotPasswordForm,
                success:function(data){
                    jQuery.notify("An email is sent to your email address to reset your password", "success", {timeout: 0});
                },
                error: function(data) { // if error occured
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
        $("#forgot-password-form").trigger("reset");
    }
</script>