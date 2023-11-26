<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\db;
use common\models\AccessToken;
use frontend\models\User\LoginUserForm;

class AuthController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    public $enableCsrfValidation = false;
    public function actionToken()
    {
        $model = new LoginUserForm();
        return $model->login();
    }
    public function actionAuthenticate($token)
    {
        $accessToken = AccessToken::find()->where(['accessToken' => $token])->one();

        if ($accessToken != null) {
            // Пользователь найден, выполните вход пользователя в систему.
            $userId = $accessToken->getUserId();
            $user = User::find()->where(['id'=> $userId])->one();
            if ($user) {
                Yii::$app->user->login($user);
                return $this->goHome();
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