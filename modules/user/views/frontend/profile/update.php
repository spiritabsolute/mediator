<?php

use yii\bootstrap\ActiveForm;
use app\modules\user\Module;
use yii\helpers\Html;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model \app\modules\user\models\frontend\form\ProfileUpdateForm */

$this->title = Module::t('module', 'TITLE_PROFILE_UPDATE');
$this->params['breadcrumbs'][] = ['label' =>
    Module::t('module', 'TITLE_PROFILE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-update">

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email')
            ->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')
            ->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'surname')
            ->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'age')
            ->textInput(['maxlength' => true]) ?>

        <?=
            $form->field($model, 'date_birth')
                ->widget(DatePicker::classname(), [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ])
        ?>

        <div class="form-group">
            <?= Html::submitButton(Module::t('module', 'BUTTON_SAVE'),
                ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
