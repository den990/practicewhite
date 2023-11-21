<?php

namespace common\controllers;

use Yii;
use yii\web\Controller;
use common\models\Comments;
use frontend\models\AccessesToken;
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
            $accessToken = AccessesToken::find()->where(['accessToken' => $token])->one();
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
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            $comment = Comments::findOne($postData['commentId']);

            if (!$comment) {
                return ['message' => 'Комментарий не найден'];
            }

            if ($comment->delete()) {
                return ['message' => 'Комментарий успешно удален'];
            } else {
                return ['message' => 'Ошибка удаления комментария'];
            }
        }
    }

    public function actionGetComments()
    {
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            $comments = Comments::find()->where(['blogId' => $postData['blogId']])->all();

            if (!empty($comments)) {
                $commentArray = [];
                foreach ($comments as $comment) {
                    $commentArray[] = [
                        'id' => $comment->id,
                        'text' => $comment->text,
                    ];
                }

                return $commentArray;
            } else {
                return ['message' => 'Нет комментариев для этого блога'];
            }
        }
        return ['message' => 'Некорректный запрос'];
    }

}