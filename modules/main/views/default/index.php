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
