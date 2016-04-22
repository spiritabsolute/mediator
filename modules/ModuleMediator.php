<?php
namespace app\modules;

use app\modules\user\events;
use app\modules\user\models\User;
use yii\base\Object;
use yii\base\BootstrapInterface;
use yii\db\ActiveRecord;
use yii\base\Event;

class ModuleMediator extends Object implements BootstrapInterface
{
    private static $checkUserEvents;

    public function bootstrap($app)
    {
        if (self::$checkUserEvents === null) {
            Event::on(User::className(), ActiveRecord::EVENT_AFTER_INSERT,
                [self::className(), 'onUserCreated']);
            Event::on(User::className(), ActiveRecord::EVENT_AFTER_UPDATE,
                [self::className(), 'onUserUpdated']);
            Event::on(User::className(), ActiveRecord::EVENT_AFTER_DELETE,
                [self::className(), 'onUserDeleted']);
            self::$checkUserEvents = true;
        }
    }

    public static function onUserCreated(Event $event)
    {
        $user =  $event->sender;
    }

    public static function onUserViewed(events\UserViewedEvent $event)
    {
        $user = $event->user;
    }

    public static function onUserUpdated(Event $event)
    {
        $user =  $event->sender;
    }

    public static function onUserDeleted(Event $event)
    {
        $user =  $event->sender;
    }
}