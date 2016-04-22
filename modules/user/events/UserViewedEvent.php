<?php
namespace app\modules\user\events;

use yii\base\Event;
use app\modules\user\models\User;

class UserViewedEvent extends Event
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}