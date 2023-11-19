<?php

namespace frontend\controllers;

use common\models\BaseUser;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\db;
use frontend\models\AccessesToken;

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
        $request=Yii::$app->getRequest();
        $email = $request->getBodyParam('email');
        $password = $request->getBodyParam('password');
        $user = BaseUser::findOne(['email' => $email]);
        if ($user && Yii::$app->getSecurity()->validatePassword($password, $user->password_hash))
        {
            $modelAccessToken = new AccessesToken();
            $modelAccessToken->accessToken = Yii::$app->security->generateRandomString();
            $modelAccessToken->idUser = $user->id;
            if ($modelAccessToken->save()) {
                return ['access_token' => $modelAccessToken->accessToken];
            }
            else
            {
                return ['message' => 'Неудалось создать Access Token'];
            }
        }
        else
        {
            Yii::$app->response->statusCode = 401;
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