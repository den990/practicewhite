<?php

namespace frontend\controllers;

use yii\web\Controller;
use Yii;
use yii\web\Response;
use yii\db;
use common\models\User;
use frontend\models\Blogs;
use frontend\models\AccessesToken;

class PublicationController extends Controller
{
    public function actionGet()
    {
        $limit = Yii::$app->request->get('limit', 10);
        $offset = Yii::$app->request->get('offset', 0);
        $accessToken = Yii::$app->request->get('accessToken');
        if ($accessToken != null)
        {
            $modelAccessToken = AccessesToken::find()->where(['accessToken' => $accessToken])->one();
            if ($modelAccessToken == null)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['message'=>'Невалидный Access Token'];
            }
            $idUser = $modelAccessToken->getUserId();
            $blogs = Blogs::find()
                ->where(['idUser' => $idUser])
                ->limit($limit)
                ->offset($offset)
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
        else {
            $blogs = Blogs::find()
                ->limit($limit)
                ->offset($offset)
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
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $publications;
    }
}