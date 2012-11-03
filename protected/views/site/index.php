<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<div class="span-16">
    <h1>Network like a Professional. For FREE!</h1>
    <ul>
        <li>Keep track of all your important contacts and access them from anywhere.</li>
        <li>Add detailed notes, tags and sort by contacts and companies.</li>
        <li>Print your company notes to help remember details during BankWeeks, on-campus visit sessions etc.</li>
        <li>Many more features coming soon! <?php echo CHtml::link('Suggest new features to better serve your needs.',array('/site/contact'));?></li>
    </ul>
</div>
<div class="span-7 last">
    <?php $this->renderPartial('login',array('model'=>$model)); ?>
</div>