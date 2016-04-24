<?php
use app\modules\main\Module;
use yii\helpers\Html;

/* @var $model app\modules\main\models\Event */
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<?= Html::encode(date('d.m.Y H:i:s', $model->created_at)) ?>
	</div>
	<div class="panel-body">
		<p>
			<?= Html::encode(Module::t('module', 'EVENT_ENTITY').$model->entity) ?>
		</p>
		<p>
			<?= Html::encode(Module::t('module', 'EVENT_TYPE').$model->type) ?>
		</p>
		<p>
			<?= Html::encode(Module::t('module', 'EVENT_AUTHOR').$model->author) ?>
		</p>

		<?php if(!empty($model->changes)): ?>
			<p><?=Module::t('module', 'EVENT_CHANGES')?></p>
			<ul class="list-group">
				<?php foreach(unserialize($model->changes) as $field => $fieldValue): ?>
					<li class="list-group-item">
						<?= Html::encode($field .' = '.$fieldValue) ?>
					</li>
				<?php endforeach ?>
			</ul>
		<?php endif ?>

	</div>
</div>