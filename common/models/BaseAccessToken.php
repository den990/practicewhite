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
 * @property integer $idUser
 * @property string $accessToken

 */

class BaseAccessToken extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return '{{%accesses_token}}';
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

    public function getUserId()
    {
        return $this->idUser;
    }

    public function getAuthKey()
    {
        throw new NotSupportedException('"getAuthKey" is not implemented.');
    }

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException('"validateAuthKey" is not implemented.');
    }



    public function removeAccessToken()
    {
        $this->accessToken = null;
    }
}