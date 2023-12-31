<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use backend\models\UserRole;
use yii\base\NotSupportedException;
use function PHPUnit\Framework\throwException;

/**
 * Login form
 */
class NewLoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     *
     */
    public function login()
    {
        $user = User::findByUsername($this->username);
        if ($user) {
            if (Yii::$app->security->validatePassword($this->password, $user->password_hash)) {
                if ($this->isAdmin()) {
                    return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
                }
            }
            else
            {
                $this->addError('password', 'Not correct password');
            }
        }
        else
        {
            $this->addError('username', 'Username not exist');
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    protected function isAdmin()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
            $idUser = $this->_user->getId();
            $modelUserRole = UserRole::find()->where(['idUser' => $idUser])->one();
            if ($modelUserRole->role != 1)
            {
                $this->addError('username', 'You must be admin');
                return false;
            }
            else
            {
                return true;
            }
        }
    }
}
