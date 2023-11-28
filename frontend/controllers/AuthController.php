<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\User\LoginUserForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\db;
use common\models\AccessToken;
use frontend\models\User\UserGetAccessTokenForm;

class AuthController extends Controller
{
    public function beforeAction($action)
    {

        return parent::beforeAction($action);
    }

    public $enableCsrfValidation = false;
    public function actionToken()
    {
        $model = new UserGetAccessTokenForm();
        return $model->getAccessToken();
    }
    public function actionAuthenticate($token)
    {
        $model = new LoginUserForm();
        $model->accessToken = $token;
        return $model->login();
    }

}