<?php
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * UserRole model
 *
 * @property integer $id
 * @property integer $idUser
 * @property integer $role
 */

class UserRole extends ActiveRecord implements IdentityInterface
{
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::ROLE_USER],
            ['status', 'in', 'range' => [self::ROLE_USER, self::ROLE_ADMIN]],
        ];
    }

    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
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

    public function setAdmin()
    {
        $this->role = self::ROLE_ADMIN;
    }

    public function setUser()
    {
        $this->role = self::ROLE_USER;
    }
}