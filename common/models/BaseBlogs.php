<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * BaseAccessToken model
 *
 * @property integer $id
 * @property string $text
 * @property integer $idUser

 */

class BaseBlogs extends ActiveRecord implements IdentityInterface
{

    public function rules()
    {
        return [
            [['text'], 'string'],
            [['idUser'], 'integer'],
            // остальные правила валидации
        ];
    }

    public static function tableName()
    {
        return '{{%blogs}}';
    }

    public function getComments()
    {
        return $this->hasMany(Comments::class, ['blogId' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        throw new NotSupportedException('"getAuthKey" is not implemented.');
    }

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException('"validateAuthKey" is not implemented.');
    }
}