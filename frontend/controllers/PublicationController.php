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

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $publications;
    }
}