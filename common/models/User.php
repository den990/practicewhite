<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Blogs;
use common\models\AccessToken;


class User extends BaseUser
{

    public function rules()
    {
        return parent::rules();
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    public function getBlogs()
    {
        return $this->hasMany(Blogs::class, ['idUser' => 'id']);
    }

    public static function getUserByAccessToken($accessToken)
    {
        $modelAccessToken = AccessToken::findOne(['accessToken' => $accessToken]);
        return User::findOne(['id' => $modelAccessToken->idUser]);
    }
}
