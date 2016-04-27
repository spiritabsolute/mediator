<?php
namespace app\modules;

use app\modules\user\models\User;
use yii\base\Object;
use yii\base\BootstrapInterface;
use yii\db\ActiveRecord;
use yii\base\Event;
use app\modules\main\models\Event as EventModel;
use yii;

//TODO
// Это просто пример для выполнения задачи. Скорее всего, можно хорошо подумать и доработать этот класс, чтобы он
// обрабатывал события с разных модулей и не было жесткой привязанности к конкретной сущности.
class ModuleMediator extends Object implements BootstrapInterface
{
	private static $checkUserEvents;

	public function bootstrap($app)
	{
		if (self::$checkUserEvents === null) {
			Event::on(User::className(), ActiveRecord::EVENT_AFTER_INSERT,
				[self::className(), 'onUserCreated']);
			Event::on(User::className(), User::EVENT_AFTER_READ,
				[self::className(), 'onUserReaded']);
			Event::on(User::className(), ActiveRecord::EVENT_AFTER_UPDATE,
				[self::className(), 'onUserUpdated']);
			Event::on(User::className(), ActiveRecord::EVENT_AFTER_DELETE,
				[self::className(), 'onUserDeleted']);
			self::$checkUserEvents = true;
		}
	}

	public static function onUserCreated(Event $event)
	{
		self::saveEvent($event);
	}

	public static function onUserReaded(Event $event)
	{
		self::saveEvent($event);
	}

	public static function onUserUpdated(Event $event)
	{
		self::saveEvent($event);
	}

	public static function onUserDeleted(Event $event)
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
		if($eventModel->save())
		{
			self::pushEventToSocket($eventModel->getAttributes());
		}
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