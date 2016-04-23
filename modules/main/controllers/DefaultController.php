<?php

namespace app\modules\main\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\modules\main\models\Event as EventModel;

class DefaultController extends Controller
{
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => EventModel::find(),
			'sort'=>array(
				'defaultOrder'=>['created_at' => SORT_DESC],
			),
			'pagination' => [
				'pageSize' => 3,
				'validatePage' => false,
			],
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider
		]);
	}
}
