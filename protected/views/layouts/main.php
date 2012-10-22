<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">
<?php $this->widget('bootstrap.widgets.TbNavbar',array(
        'type'=>'inverse',
        'brand'=>CHtml::encode(Yii::app()->name),
        'collapse'=>true,
        'items'=>array(
                array(
                        'class'=>'bootstrap.widgets.TbMenu',
                        'items'=>array(
                                array('label'=>'Demo', 'url'=>Yii::app()->homeUrl,
                                                'active'=>Yii::app()->controller->id === 'site' && Yii::app()->controller->action->id === 'index'),
                                array('label'=>'Setup', 'url'=>array('site/setup')),
                        ),
                        'htmlOptions'=>array('class'=>'pull-left'),
                ),
                '<div class="add-this pull-right">
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style">
                        <a class="addthis_button_facebook"></a>
                        <a class="addthis_button_twitter"></a>
                        <a class="addthis_button_google"></a>
                        <a class="addthis_button_email"></a>
                        <a class="addthis_button_compact"></a>
                        <a class="addthis_counter addthis_bubble_style"></a>
                        </div>
                        <!-- AddThis Button END -->
                </div>',
                array(
                        'class'=>'bootstrap.widgets.TbMenu',
                        'items'=>array(
                                array('label'=>'Bootstrap Docs', 'url'=>'http://twitter.github.com/bootstrap', 'linkOptions'=>array('target'=>'_blank')),
                                array('label'=>'Fork me on Bitbucket', 'url'=>'http://www.bitbucket.org/Crisu83/yii-bootstrap', 'linkOptions'=>array('target'=>'_blank')),
                                array('label'=>'Follow me on Twitter', 'url'=>'http://www.twitter.com/Crisu83', 'linkOptions'=>array('target'=>'_blank')),
                        ),
                        'htmlOptions'=>array('class'=>'pull-right'),
                ),
        ),
)); ?>
	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
