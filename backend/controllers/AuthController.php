<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\db;
use common\models\User;

class AuthController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionToken()
    {
        $request=Yii::$app->getRequest();
        $email = $request->getBodyParam('email');
        $password = $request->getBodyParam('password');
        $user = User::findOne(['email' => $email]);
        if ($user && Yii::$app->getSecurity()->validatePassword($password, $user->password_hash))
        {
            $accessToken = Yii::$app->security->generateRandomString();
            $user->access_token = $accessToken;
            $user->save();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['access_token' => $accessToken];
        }
        else
        {
            Yii::$app->response->statusCode = 401;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['message' => 'Пользователь не существует'];
        }
    }
    public function actionAuthenticate($token)
    {
        $user = User::find()->where(['access_token' => $token])->one();

        if ($user) {
            // Пользователь найден, выполните вход пользователя в систему.
            Yii::$app->user->login($user);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->goHome();
        } else {
            Yii::$app->response->statusCode = 401;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['message' => 'Неверный токен'];
        }
    }

}