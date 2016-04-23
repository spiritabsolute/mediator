<?php
namespace app\modules\main\assets;

use yii\web\AssetBundle;

class ModuleAsset extends AssetBundle
{
	public $sourcePath = '@app/modules/main/assets';
	public $css = [
        'css/desktop.css',
	];
	public $js = [
		'js/script.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
	];
}
