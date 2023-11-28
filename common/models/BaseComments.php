<?php

namespace common\models;

use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Comments model
 *
 * @property integer $id
 * @property string $text
 * @property integer $userId
 * @property integer $blogId

 */


class BaseComments  extends ActiveRecord implements IdentityInterface
{

    public function rules()
    {
        return [
            [['text', 'blogId'], 'required'],
            [['text'], 'string'],
            [['blogId'], 'integer'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }

    public function getBlog()
    {
        return $this->hasOne(Blogs::class, ['id' => 'blogId']);
    }

    public static function findIdentity($id)
    {
        throw new NotSupportedException('"findIdentity" is not implemented.');
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        throw new NotSupportedException('"getAuthKey" is not implemented.');
    }

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException('"validateAuthKey" is not implemented.');
    }

    public function shortSerialize()
    {
        return [
            'id' => $this['id'],
            'text' => $this['text'],
        ];
    }

    public function longSerialize()
    {
        return [
            'id' => $this['id'],
            'text' => $this['text'],
            'blogId' => $this['blogId'],
            'userId' => $this['userId']
        ];
    }
}