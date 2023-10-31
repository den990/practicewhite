<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\db;
use common\models\User;
use frontend\models\AccessesToken;

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
            // TODO создать в отдельную таблицу
            $modelAccessToken = new AccessesToken();
            $modelAccessToken->accessToken = Yii::$app->security->generateRandomString();
            $modelAccessToken->idUser = $user->id;
            if ($modelAccessToken->save()) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['access_token' => $modelAccessToken->accessToken];
            }
            else
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['message' => 'Неудалось создать Access Token'];
            }
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
        $accessToken = AccessesToken::find()->where(['accessToken' => $token])->one();

        if ($accessToken != null) {
            // Пользователь найден, выполните вход пользователя в систему.
            $userId = $accessToken->getUserId();
            $user = User::find()->where(['id'=> $userId])->one();
            if ($user) {
                Yii::$app->user->login($user);
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $this->goHome();
            }
            else{
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['message' => 'Нет пользователя с таким accessToken'];
            }
        } else {
            Yii::$app->response->statusCode = 401;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['message' => 'Нет такого токена'];
        }
    }

}