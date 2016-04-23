<?php

namespace app\modules\main\models;

use Yii;
use yii\db\ActiveRecord;
use app\modules\main\Module;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%event}}".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $entity
 * @property string $type
 * @property integer $author
 * @property string $changes
 */
class Event extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%event}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity', 'type', 'author'], 'required'],
            [['author'], 'integer'],
            [['changes'], 'string'],
            [['type', 'entity'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => Module::t('module', 'EVENT_CREATED'),
            'updated_at' => Module::t('module', 'EVENT_UPDATED'),
            'entity' => Module::t('module', 'EVENT_ENTITY'),
            'type' => Module::t('module', 'EVENT_TYPE'),
            'author' => Module::t('module', 'EVENT_AUTHOR'),
            'changes' => Module::t('module', 'EVENT_CHANGES'),
        ];
    }
}
