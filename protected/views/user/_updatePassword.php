<?php
/* @var $this UserController */
/* @var $updateForm User */
/** @var TbActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'update-password-form',
    'type'=>'horizontal',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false
));
?>
<fieldset>

    <legend><?php echo CHtml::encode($tabHeader); ?></legend>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->passwordFieldRow($updateForm, "password"); ?>
    <?php echo $form->passwordFieldRow($updateForm, "newPassword1"); ?>
    <?php echo $form->passwordFieldRow($updateForm, "newPassword2"); ?>

</fieldset>
<div class="btn-toolbar" style="margin-left: 200px">
    <?php
        $this->widget('bootstrap.widgets.TbButton',
        array(
            'buttonType'=>'button',
            'type'=>'primary',
            'label'=>'Submit',
            'htmlOptions'=>array(
            'onClick'=> 'updatePasswordJS()',
            ))
        ); ?>
    <?php
        $this->widget('bootstrap.widgets.TbButton',
            array(
                'buttonType'=>'reset',
                'label'=>'Reset'
            )
        ); ?>
</div>

<?php $this->endWidget(); ?>
<style type="text/css">
    .error{
        color: #990000;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $("#update-password-form").bind("reset",function(){
            $("div[class='error']").remove();
            $("input[id*='_']").removeClass("error");
        });
        jQuery.validator.setDefaults({
            errorElement: "div"
        });
        validatePasswordResetForm();
    });
    //validate User registration form
    function validatePasswordResetForm(){
        jQuery.validator.addMethod(
                "reenterPassword",
                function(value, element) {
                    return $('#UpdatePasswordForm_newPassword1').val()==value;
                },
                "Password 2 doesn't match with password1"
        );
        var passwordFormValidator = $("#update-password-form").validate({
            rules: {
                'UpdatePasswordForm[password]': {
                    required: true
                },
                'UpdatePasswordForm[newPassword1]': {
                    required: true,
                    minlength:6
                },
                'UpdatePasswordForm[newPassword2]': {
                    required: true,
                    reenterPassword:true
                }
            },
            messages: {
                'UpdatePasswordForm[password]':{
                    required: "Current password is required"
                },
                'UpdatePasswordForm[newPassword1]': {
                    required: "Password is required",
                    minlength:"Password length must be 6 characters"
                },
                'UpdatePasswordForm[newPassword2]': {
                    required: "Password 2 is required"
                }
            }
        })
    }
    //Update user password
    function updatePasswordJS()
    {
        var updatePwForm = $("#update-password-form");
        if(updatePwForm.validate().form()){
            var data=updatePwForm.serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("user/updatePassword"); ?>',
                data:data,
                success:function(data){
                    jQuery.notify("Password updated successfully", "success");
                },
                error: function(data) { // if error occured
                    if(data.status==400){
                        jQuery.notify("Current password is not correct", "error");
                    }else{
                        jQuery.notify("Unable to update password. Please try again", "error");
                    }
                }
            });
            updatePwForm.trigger("reset");
        }
    }
</script>