<?php

namespace frontend\controllers;

use yii\web\Controller;
use Yii;
use yii\web\Response;
use yii\db;
use common\models\User;
use frontend\models\Blogs;
use frontend\models\AccessesToken;

class BlogsController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionPublish() {
        $request = Yii::$app->getRequest();
        $accessToken = $request->getBodyParam('access_token');
        $text = $request->getBodyParam('text');
        if ($accessToken && $text)
        {
            $modelBlogs = new Blogs();
            $modelAccessToken = AccessesToken::find()->where(['accessToken' => $accessToken])->one();
            if ($modelAccessToken) {
                $modelBlogs->text = $text;
                $modelBlogs->idUser = $modelAccessToken->getUserId();
                if ($modelBlogs->save()) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['message' => 'Пост сохранён'];
                } else {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['message' => 'Произошла ошибка при сохранении'];
                }
            }
            else
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['message' => 'Невалидный Access Token'];
            }
        }
        else
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['message' => 'Заполните все данные'];
        }
    }
}