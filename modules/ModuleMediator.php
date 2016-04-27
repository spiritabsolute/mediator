<?php
namespace app\modules;

use yii\base\Object;
use yii\base\BootstrapInterface;
use yii\db\ActiveRecord;
use yii\base\Event;
use app\modules\main\models\Event as EventModel;
use yii;

class ModuleMediator extends Object implements BootstrapInterface
{
	private static $checkEvents;

	public function bootstrap($app)
	{
		if (self::$checkEvents === null)
		{
			Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT,
				[self::className(), 'onCreated']);
			Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_UPDATE,
				[self::className(), 'onUpdated']);
			Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_DELETE,
				[self::className(), 'onDeleted']);

			self::$checkEvents = true;
		}
	}

	public static function onCreated(Event $event)
	{
		self::saveEvent($event);
	}

	public static function onUpdated(Event $event)
	{
		self::saveEvent($event);
	}

	public static function onDeleted(Event $event)
	{
		self::saveEvent($event);
	}

	private static function saveEvent(Event $event)
	{
		if(!Yii::$app->user->identity)
			return;

		$eventModel = new EventModel();
		$eventModel->entity = get_class($event->sender);
		$eventModel->type = $event->name;
		$eventModel->author = Yii::$app->user->identity->getId();
		if(!empty($event->changedAttributes))
		{
			$eventModel->changes = serialize($event->changedAttributes);
		}

		Event::off(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT);

		if($eventModel->save())
		{
			self::pushEventToSocket($eventModel->getAttributes());
		}

		Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT,
			[self::className(), 'onCreated']);
	}

	private static function pushEventToSocket(array $eventModel)
	{
		$context = new \ZMQContext();
		$socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'desktop');
		if($socket instanceof \ZMQSocket)
		{
			$eventModel['subscribeKey'] = 'eventMonitoring';
			$eventData = json_encode($eventModel);
			$socket->connect("tcp://127.0.0.1:5555");
			$socket->send($eventData);
		}
	}
}