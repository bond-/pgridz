<?php
$this->breadcrumbs=array(
    'Users'=>array('index'),
    'My Profile',
);

$this->widget('bootstrap.widgets.TbTabs', array(
    'tabs'=>$this->getTabularFormTabs(),
)); ?>

<script type="text/javascript">
    $("a[href^='#yw1']").click(function() {
        $("div[class='error']").remove();
        $("input[id*='_']").removeClass("error");
        $("#update-password-form").trigger("reset");
    });
    $("a[href='#yw1_tab_2']").click(function() {
        $.ajax({
            type: 'GET',
            url: '<?php echo Yii::app()->createAbsoluteUrl("user/renderPartialView"); ?>',
            success:function(data){
                $('#viewProfile').html(data);
            },
            error: function(data) { // if error occured
            }
        });
    });
    $("a[href='#yw1_tab_3']").click(function() {
        $.ajax({
            type: 'GET',
            url: '<?php echo Yii::app()->createAbsoluteUrl("user/renderPartialEdit"); ?>',
            success:function(data){
                $('#viewProfile').html(data);
            },
            error: function(data) { // if error occured
            }
        });
    });
</script>
