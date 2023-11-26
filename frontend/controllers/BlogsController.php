<?php

namespace frontend\controllers;

use frontend\models\Blogs\BlogsPublishForm;
use frontend\models\Blogs\BlogsListForm;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\db;

class BlogsController extends Controller
{
    public $enableCsrfValidation = false;
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionGet()
    {
        $model = new BlogsListForm();
        $model->blogs = $model->getBlogsList();
        return $model->serialize();
    }

    public function actionPub() {
        $model = new BlogsPublishForm();
        return $model->publish();
    }
}