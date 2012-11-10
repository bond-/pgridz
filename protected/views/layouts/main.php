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
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
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
                array('label'=>'My Profile', 'url'=>array('/user/view'),'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Suggestion/Comment', 'url'=>array('/site/contact')),
                array('label'=>'Contacts', 'url'=>array('/contact/index'),'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Companies', 'url'=>array('/company/index'),'visible'=>!Yii::app()->user->isGuest),
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

<div class="container" id="page">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
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
