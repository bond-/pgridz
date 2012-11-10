<?php
/* @var $this UserController */
/* @var $data User */
/** @var TbActiveForm $form */
/* @var $profileForm User */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'profile-update-form',
    'type'=>'horizontal',
));
?>

<fieldset>

    <legend><?php echo CHtml::encode($tabHeader); ?></legend>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->textFieldRow($profileForm, "email"); ?>
    <?php echo $form->textFieldRow($profileForm, "city"); ?>
    <?php echo $form->textFieldRow($profileForm, "state"); ?>
    <?php echo $form->textFieldRow($profileForm, "country"); ?>
    <?php echo $form->textFieldRow($profileForm, "zip"); ?>
</fieldset>

<div class="btn-toolbar" style="margin-left: 200px">
    <?php
    $this->widget('bootstrap.widgets.TbButton',
        array(
            'buttonType'=>'button',
            'type'=>'primary',
            'label'=>'Submit',
            'htmlOptions'=>array(
                'onclick'=> 'updateProfileJS()',
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

<script type="text/javascript">
    $(document).ready(function() {
        jQuery.validator.setDefaults({
            errorElement: "div"
        });
        validateProfileUpdateForm();
    });
    //validate User registration form
    function validateProfileUpdateForm(){
        $("#profile-update-form").validate({
            rules: {
                'User[email]': {
                    required: true
                }
            },
            messages: {
                'User[email]':{
                    required: "Email is required"
                }
            }
        })
    }

    function updateProfileJS()
    {
        if($("#profile-update-form").validate().form()){
            var data=$("#profile-update-form").serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("user/updateProfile"); ?>',
                data:data,
                success:function(data){
                    jQuery.notify("Profile updated successfully", "success", {timeout: 0});
                },
                error: function(data) { // if error occured
                    jQuery.notify("Unable to update profile. Please try again", "error", {timeout: 0});
                }
            });
        }
    }

</script>