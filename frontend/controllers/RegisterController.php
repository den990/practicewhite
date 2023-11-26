<?php

namespace frontend\controllers;


use yii\web\Controller;
use Yii;
use yii\web\Response;
use yii\db;
use common\models\User;
use frontend\models\User\RegistrationUserForm;

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
        $model = new RegistrationUserForm();
        return $model->registration();
    }
}