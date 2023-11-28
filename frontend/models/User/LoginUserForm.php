<?php

namespace frontend\models\User;

use Yii;
use common\models\AccessToken;
use common\models\User;
use yii\base\Model;

class LoginUserForm extends Model
{
    public $accessToken;

    public function rules()
    {
        return [
            ['accessToken', 'required']
        ];
    }

    public function init()
    {

    }

    public function login()
    {
        $accessToken = AccessToken::find()->where(['accessToken' => $this->accessToken])->one();

        if ($accessToken != null) {
            $userId = $accessToken->getUserId();
            $user = User::find()->where(['id'=> $userId])->one();
            if ($user) {
                Yii::$app->user->login($user);
                return Yii::$app->getResponse()->redirect(['/site/index']);
            }
            else{
                return ['message' => 'Нет пользователя с таким accessToken'];
            }
        } else {
            Yii::$app->response->statusCode = 401;
            return ['message' => 'Нет такого токена'];
        }
    }
}