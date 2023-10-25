<?php

namespace backend\controllers;

use yii\web\Controller;
use Yii;
use yii\web\Response;
use yii\db;
use common\models\User;
// TODO перенести во frontend UserController
class RegisterController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionRegistration()
    {
        $request = Yii::$app->getRequest();
        $email = $request->getBodyParam('email');
        $password = $request->getBodyParam('password');
        $username = $request->getBodyParam('username');
        var_dump($email, " " ,$password, " ", $username);
        if ($email!= null && $password!=null && $username!=null)
        {
            // получить пользователя здесь
            if (!(User::find()->where(['email' => $email])->one() || (User::find()->where(['username' => $username])->one())))
            {
                $user = new User;
                $user->username = $username;
                $user->email = $email;
                $user->setPassword($password);
                $user->generateAuthKey();
                $user->generateEmailVerificationToken();
                $access_token = Yii::$app->security->generateRandomString();
                $user->access_token = $access_token;
                $user->status = 10;
                // TODO обработка ошибки при сохранении
                $user->save();
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['message' => 'Пользователь зарегестрирован',
                    'access_token' => $access_token];
            }
            else
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['message' => 'Пользователь с таким email или username уже существует'];
            }
        }
        else
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['message' => 'Нужно ввести username, email, password'];
        }
    }
}