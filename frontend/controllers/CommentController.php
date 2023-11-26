<?php

namespace frontend\controllers;

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
        if (Yii::$app->request->isPost)
        {
            $modelComments = new Comments();
            $postData = Yii::$app->request->post();
            $modelComments->load($postData, '');
            $token = $postData['access_token'];
            $accessToken = AccessToken::find()->where(['accessToken' => $token])->one();
            if ($accessToken)
            {
                $modelComments->userId = $accessToken->idUser;
                if ($modelComments->save())
                {
                    return ['message' => 'Комментарий сохранен'];
                }
                else
                {
                    return ['message' => 'Ошибка сохранения комментария'];
                }
            }
            else
            {
                return ['message' => 'Такого пользователя не существует'];
            }
        }
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