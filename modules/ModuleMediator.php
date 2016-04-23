<?php
namespace app\modules;

use app\modules\user\models\User;
use yii\base\Object;
use yii\base\BootstrapInterface;
use yii\db\ActiveRecord;
use yii\base\Event;
use app\modules\main\models\Event as EventModel;
use yii;

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
        $eventModel = new EventModel();
        $eventModel->entity = get_class($event->sender);
        $eventModel->type = $event->name;
        $eventModel->author = Yii::$app->user->identity->getId();
        if(!empty($event->changedAttributes))
            $eventModel->changes = serialize($event->changedAttributes);
        $eventModel->save();
    }
}