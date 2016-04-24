<?php
namespace app\components\desktop;

use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;
use Ratchet\Wamp\Topic;
use yii\helpers\Html;

class EventPusher implements WampServerInterface
{
	protected $subscribedTopics = array();

	public function onSubscribe(ConnectionInterface $conn, $topic)
	{
		$subject = $topic->getId();
		if (!array_key_exists($subject, $this->subscribedTopics))
		{
			$this->subscribedTopics[$subject] = $topic;
		}
	}

	public function onPushEventData($event)
	{
		$eventData = json_decode($event, true);

		if (!array_key_exists($eventData['subscribeKey'], $this->subscribedTopics))
		{
			return;
		}

		$topic = $this->subscribedTopics[$eventData['subscribeKey']];

		if($topic instanceof Topic)
		{
			foreach($eventData as $eventField => &$fieldValue)
			{
				if($eventField == 'changes')
					continue;
				$fieldValue = Html::encode($fieldValue);
			}

			if(!empty($eventData['changes']))
				$eventData['changes'] = unserialize($eventData['changes']);

			$topic->broadcast($eventData);
		}
		else
		{
			return;
		}
	}

	public function onCall(ConnectionInterface $conn, $id, $topic, array $params)
	{
		$conn->callError($id, $topic, 'You are not allowed to make calls')->close();
	}

	public function onPublish(ConnectionInterface $conn, $topic, $event, array
	$exclude, array $eligible)
	{
		$conn->close();
	}

	public function onUnSubscribe(ConnectionInterface $conn, $topic){}

	public function onOpen(ConnectionInterface $conn){}

	public function onClose(ConnectionInterface $conn){}

	public function onError(ConnectionInterface $conn, \Exception $e){}
}