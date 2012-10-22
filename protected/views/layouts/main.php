<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
        'type'=>'inverse',
        'brand'=>CHtml::encode(Yii::app()->name),
        'collapse'=>true,
        'items'=>array(
                array(
                        'class'=>'bootstrap.widgets.TbMenu',
                        'items'=>array(
                                array('label'=>'Home', 'url'=>Yii::app()->homeUrl,
                                                'active'=>Yii::app()->controller->id === 'site' && Yii::app()->controller->action->id === 'index'),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                                array('label'=>'Contact', 'url'=>array('/site/contact')),
                        ),
                        'htmlOptions'=>array('class'=>'pull-left'),
                ),
                array(
                        'class'=>'bootstrap.widgets.TbMenu',
                        'items'=>array(
                                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                        ),
                        'htmlOptions'=>array('class'=>'pull-right'),
                ),
        ),
)); ?>
<div class="container" id="page">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<footer>
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</footer><!-- footer -->

</div><!-- page -->

</body>
</html>
