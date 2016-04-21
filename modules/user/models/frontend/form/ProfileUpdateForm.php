<?php

namespace app\modules\user\models\frontend\form;

use app\modules\user\models\User;
use app\modules\user\Module;
use yii\base\Model;
use yii\db\ActiveQuery;
use Yii;

class ProfileUpdateForm extends Model
{
    public $email;
    public $name;
    public $surname;
    public $age;
    public $date_birth;

    /**
     * @var User
     */
    private $_user;

    /**
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }

    public function init()
    {
        $this->email = $this->_user->email;
        $this->name = $this->_user->name;
        $this->surname = $this->_user->surname;
        $this->age = $this->_user->age;
        $this->date_birth = $this->_user->date_birth;

        parent::init();
    }

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => User::className(),
                'message' => Module::t('module', 'ERROR_EMAIL_EXISTS'),
                'filter' => function (ActiveQuery $query) {
                        $query->andWhere(['<>', 'id', $this->_user->id]);
                    },
            ],
            [['email', 'name', 'surname'], 'string', 'max' => 255],
            [['age'], 'integer'],
            [['date_birth'], 'date', 'format' => 'php:Y-m-d'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Module::t('module', 'USER_NAME'),
            'surname' => Module::t('module', 'USER_SURNAME'),
            'age' => Module::t('module', 'USER_AGE'),
            'date_birth' => Module::t('module', 'USER_DATE_BIRTH'),
        ];
    }

    /**
     * @return bool
     */
    public function update()
    {
        if ($this->validate())
        {
            $user = $this->_user;
            $user->email = $this->email;
            $user->name = $this->name;
            $user->surname = $this->surname;
            $user->age = $this->age;
            $user->date_birth = $this->date_birth;
            return $user->save();
        }
        else
        {
            return false;
        }
    }
} 