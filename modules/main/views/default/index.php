<?php
use yii\widgets\Pjax;
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
use app\modules\main\Module;
use app\modules\main\assets\ModuleAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name;
$bundle = ModuleAsset::register($this);
$this->registerCssFile($bundle->baseUrl.'/css/desktop.css',
	['depends'=>'app\assets\AppAsset']);
$this->registerJsFile($bundle->baseUrl.'/js/desktop.js',
	['depends'=>'app\assets\AppAsset']);
$this->registerJsFile('//autobahn.s3.amazonaws.com/js/autobahn.min.js');
?>
<div class="main-default-index">
	<?php
		Pjax::begin();
			echo ListView::widget([
				'id' => 'listEvents',
				'dataProvider' => $dataProvider,
				'itemOptions' => ['class' => 'item'],
				'itemView' => 'event-block',
				'pager' => [
					'class' => ScrollPager::className(),
					'triggerText' => Module::t('module', 'EVENT_VIEW_TRIGGER_TEXT'),
					'triggerTemplate' => '
						<nav>
							<ul class="pager">
								<li><a class="main-desktop-link">{text}</a></li>
							</ul>
						</nav>
					',
					'noneLeftText' => Module::t('module', 'EVENT_VIEW_NONE_LEFT_TEXT'),
					'noneLeftTemplate' => '
						<div class="main-desktop-left-template">{text}</div>
					',
				],
				'summary' => false,
				'emptyTextOptions' => ['class' => 'alert alert-danger'],
			]);
		Pjax::end();
	?>
</div>

<div class="storage-lables-text">
	<p id="lable-entity"><?=Module::t('module', 'EVENT_ENTITY')?></p>
	<p id="lable-type"><?=Module::t('module', 'EVENT_TYPE')?></p>
	<p id="lable-author"><?=Module::t('module', 'EVENT_AUTHOR')?></p>
	<p id="lable-changes"><?=Module::t('module', 'EVENT_CHANGES')?></p>
</div>
<div id="storage-template-event-block" class="storage-template-event-block">
	<div class="panel panel-default">
		<div id="panel-heading" class="panel-heading">
		</div>
		<div id="panel-body" class="panel-body">
			<p id="panel-body-entity"></p>
			<p id="panel-body-type"></p>
			<p id="panel-body-author"></p>
		</div>
	</div>
</div>
