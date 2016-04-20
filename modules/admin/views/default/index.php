<?php
use app\modules\admin\Module;
use app\modules\user\Module as UserModule;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Module::t('module', 'ADMIN');
?>
<div class="admin-default-index">
    <?= Html::a(UserModule::t('module', 'ADMIN_USERS'), ['users/default/index'],
        ['class' => 'btn btn-info']) ?>
</div>
