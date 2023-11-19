<?php

namespace frontend\controllers;

use common\models\BaseUser;
use yii\web\Controller;
use Yii;
use yii\web\Response;
use yii\db;
use common\models\User;
use frontend\models\AccessesToken;

// TODO перенести во frontend UserController
class RegisterController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    public $enableCsrfValidation = false;
    public function actionRegistration()
    {
        $request = Yii::$app->getRequest();
        $email = $request->getBodyParam('email');
        $password = $request->getBodyParam('password');
        $username = $request->getBodyParam('username');
        if ($email!= null && $password!=null && $username!=null)
        {
            $getUser = User::find()->where(['email' => $email])->one() && User::find()->where(['username' => $username])->one();
            if (!$getUser)
            {
                $user = new BaseUser();
                $user->username = $username;
                $user->email = $email;
                $user->setPassword($password);
                $user->generateAuthKey();
                $user->status = 10;
                $modelAccessToken = new AccessesToken();
                $modelAccessToken->accessToken =Yii::$app->security->generateRandomString();
                // TODO обработка ошибки при сохранении
                if ($user->save()) {
                    $modelAccessToken->idUser = $user->getId();
                    if ($modelAccessToken->save()) {
                        return ['message' => 'Пользователь зарегестрирован',
                            'access_token' => $modelAccessToken->accessToken];
                    }
                }
                else
                {
                    return ['message' => 'Произошла ошибка при сохранении пользователя'];
                }
            }
            else
            {
                return ['message' => 'Пользователь с таким email или username уже существует'];
            }
        }
        else
        {
            return ['message' => 'Нужно ввести username, email, password'];
        }
    }
}