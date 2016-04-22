<?php
namespace app\modules\user;

use Yii;
use app\modules\user\events;

class Module extends \yii\base\Module
{
    const EVENT_USER_VIEWED = 'userViewed';

	/**
	 * @var int
	 */
	public $emailConfirmTokenExpire = 259200; // 3 days
	/**
	 * @var int
	 */
	public $passwordResetTokenExpire = 3600;

	public static function t($category, $message, $params = [], $language = null)
	{
		return Yii::t('modules/user/' . $category, $message, $params, $language);
	}

    public function notifyThatUserViewed($user)
    {
        $this->trigger(Module::EVENT_USER_VIEWED, new events\UserViewedEvent($user));
    }
}