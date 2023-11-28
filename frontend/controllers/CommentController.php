<?php

namespace frontend\controllers;

use frontend\models\Comments\CommentCreateForm;
use frontend\models\Comments\CommentDeleteForm;
use frontend\models\Comments\CommentListForm;
use Yii;
use yii\web\Controller;
use common\models\Comments;
use common\models\AccessToken;
use yii\web\Response;

class CommentController extends Controller
{
    public $enableCsrfValidation = false;
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    public function actionCreate()
    {
        $model = new CommentCreateForm();
        return $model->create();
    }

    public function actionDelete()
    {
        $model = new CommentDeleteForm();
        if ($model->validate())
        {
            return $model->delete();
        }
        else
        {
            return ['message'=> 'Ошибка при удалении'];
        }
    }

    public function actionGetComments()
    {
        $model = new CommentListForm();
        $model->comments = $model->getCommentsList();
        return $model->serialize();
    }

}