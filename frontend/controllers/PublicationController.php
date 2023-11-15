<?php

namespace frontend\controllers;

use yii\web\Controller;
use Yii;
use yii\web\Response;
use yii\db;
use common\models\User;
use common\models\Blogs;
use frontend\models\AccessesToken;
use frontend\models\PostListForm;

class PublicationController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    public function actionGet()
    {
        $modelPostListForm = new PostListForm();
        if ($modelPostListForm->load(Yii::$app->request->get(), '') && $modelPostListForm->validate()) {


            if ($modelPostListForm->accessToken != null) {
                $modelAccessToken = AccessesToken::find()->where(['accessToken' => $modelPostListForm->accessToken])->one();
                if (!$modelAccessToken) {
                    return ['message' => 'Невалидный Access Token'];
                }
                $idUser = $modelAccessToken->getUserId();
                $blogs = Blogs::find()
                    ->where(['idUser' => $idUser])
                    ->limit($modelPostListForm->limit)
                    ->offset($modelPostListForm->offset)
                    ->all();
                $publications = [];
                foreach ($blogs as $blog) {
                    $publication = [
                        'id' => $blog->id,
                        'text' => $blog->text,
                        'idUser' => $blog->idUser,
                    ];
                    $publications[] = $publication;
                }
            } else {
                $blogs = Blogs::find()
                    ->limit($modelPostListForm->limit)
                    ->offset($modelPostListForm->offset)
                    ->all();
                $publications = [];
                foreach ($blogs as $blog) {
                    $publication = [
                        'id' => $blog->id,
                        'text' => $blog->text,
                        'idUser' => $blog->idUser,
                    ];
                    $publications[] = $publication;
                }
            }
        }
        else
        {
            return ['message' => 'Невалидные данные'];
        }
        return $publications;
    }
}