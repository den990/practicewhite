<?php
namespace frontend\models\User;

use common\models\AccessToken;
use Yii;
use yii\base\Model;
use common\models\User;

class UserGetAccessTokenForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['password'], 'required'],
            [['email'], 'email'],
        ];
    }

    public function init() {
        $this->attributes = Yii::$app->request->post();
    }

    public function getAccessToken() //TODO Мб перенести
    {
        $user = User::findByEmail($this->email);
        if ($user && Yii::$app->getSecurity()->validatePassword($this->password, $user->password_hash))
        {
            $modelAccessToken = AccessToken::findOne(['idUser' => $user->getId()]);
            return ['access_token' => $modelAccessToken->accessToken];
        }
        else
        {
            Yii::$app->response->statusCode = 401;
            return ['message' => 'Пользователь не существует'];
        }
    }
}