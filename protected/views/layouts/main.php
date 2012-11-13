<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" media="screen, projection" />
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php
    Yii::app()->clientScript->registerCssFile(
        Yii::app()->baseUrl.'/css/jquery.notify.css','screen,projection');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.notify.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.validate-1.10.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/additional-methods-1.10.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.blockUI.js');
    ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <script type="text/javascript">
        $(document).ready(function(){
        <?php if(Yii::app()->user->hasFlash('success')): ?>
            $(document).ready(function(){jQuery.notify("<?php echo Yii::app()->user->getFlash('success') ?>", "success", {timeout: 0});});
            <?php endif; ?>
        <?php if(Yii::app()->user->hasFlash('warning')): ?>
            $(document).ready(function(){jQuery.notify("<?php echo Yii::app()->user->getFlash('warning') ?>", "warning", {timeout: 0});});
            <?php endif; ?>
        <?php if(Yii::app()->user->hasFlash('error')): ?>
            $(document).ready(function(){jQuery.notify("<?php echo Yii::app()->user->getFlash('error') ?>", "error", {timeout: 0});});
            <?php endif; ?>
        });
        <?php if(!Yii::app()->user->isGuest && User::model()->findByPk(Yii::app()->user->id)->getAccountLocked()):?>
            function sendVerificationMail(){
                $.ajax('<?php echo $this->createUrl('/user/sendVerificationEmail')?>',{
                    beforeSend:showLoading,
                    success:function(){
                        hideLoading();
                        jQuery.notify("Email has been sent successfully", "success", {timeout: 0})
                    },
                    error:function(data){
                        hideLoading();
                        if(data.status==403){
                            jQuery.notify("You are not authorized to perform this action", "warning", {timeout: 0})
                        }else{
                            jQuery.notify("Unable to send email now, please try again later", "error", {timeout: 0})
                        }
                    }
                });
            }
            <?php endif; ?>
        function showLoading(){
            $.blockUI();
        }
        function hideLoading(){
            $.unblockUI();
        }
    </script>

</head>

<body>
<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'inverse', // null or 'inverse'
    'brand'=>CHtml::encode(Yii::app()->name),
    'brandUrl'=>array('/site/index'),
    'collapse'=>true, // requires bootstrap-responsive.css
    'htmlOptions'=>array('id'=>'mainmenu'),
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Home', 'url'=>array('/site/index'),'visible'=>Yii::app()->user->isGuest),
                array('label'=>'About Us', 'url'=>array('/site/page', 'view'=>'about'),'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Contacts','visible'=>(!Yii::app()->user->isGuest && !User::model()->findByPk(Yii::app()->user->id)->getAccountLocked()),'items'=>array(array('label'=>'Home', 'url'=>array('/contact/index'),),array('label'=>'Upload', 'url'=>array('/contact/upload'),))),
                array('label'=>'My Profile', 'url'=>array('/user/view'),'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Suggestion/Comment', 'url'=>array('/site/contact')),
            ),
        ),
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        ),
    ),
)); ?><!-- mainmenu -->

<div class="container-fluid" id="page">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
    <?php if(!Yii::app()->user->isGuest && User::model()->findByPk(Yii::app()->user->id)->getAccountLocked()):?>
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Warning!</strong> Please verify your email to access advanced features. Click <a href="javascript:sendVerificationMail()">here</a> to send verification email.
    </div>
    <?php endif?>
    <?php echo $content; ?>
    <hr/>
    <footer>
        <div class="container-fluid">
            <p class="muted credit">
                Copyright &copy; <?php echo date('Y'); ?> by Powergridz.com | All Rights Reserved | <?php echo Yii::powered(); ?>
            </p>
        </div>
    </footer><!-- footer -->
</div><!-- page -->

</body>
</html>
