<?php
$this->breadcrumbs=array(
    'My Profile',
);?>
<div class="span9">
    <?php
    $this->widget('bootstrap.widgets.TbTabs', array(
        'tabs'=>$this->getTabularFormTabs(),
    ));?>
</div>

<script type="text/javascript">
    $("a[href^='#yw1']").click(function() {
        $("div[class='error']").remove();
        $("input[id*='_']").removeClass("error");
        $("#update-password-form").trigger("reset");
    });
    function renderViewProfileJS(){
        $.ajax({
            type: 'GET',
            url: '<?php echo Yii::app()->createAbsoluteUrl("user/renderPartialView"); ?>',
            success:function(data){
                $('#viewProfile').html(data);
            },
            error: function(data) { // if error occured
            }
        });
    }
    function renderEditProfileJS(){
        $.ajax({
            type: 'GET',
            url: '<?php echo Yii::app()->createAbsoluteUrl("user/renderPartialEdit"); ?>',
            success:function(data){
                $('#viewProfile').html(data);
            },
            error: function(data) { // if error occured
            }
        });
    }
</script>
