<?php

namespace frontend\models\Blogs;

use Yii;
use common\models\BaseBlogs;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\models\Blogs;
use common\models\AccessToken;

class BlogsPublishForm extends Model
{
    public $accessToken;
    public $text;


    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
    }
    public function rules()
    {
        return [
            [['accessToken', 'text'], 'required']
        ];
    }

    public function publish()
    {
        $request = Yii::$app->getRequest();
        $this->accessToken = $request->getBodyParam('access_token');
        $this->text = $request->getBodyParam('text');
        if ($this->validate())
        {
            $modelBlogs = new Blogs();
            $modelAccessToken = AccessToken::find()->where(['accessToken' => $this->accessToken])->one();
            if ($modelAccessToken) {
                $modelBlogs->text = $this->text;
                $modelBlogs->idUser = $modelAccessToken->getUserId();
                if ($modelBlogs->save()) {
                    return ['message' => 'Пост сохранён'];
                } else {
                    return ['message' => 'Произошла ошибка при сохранении'];
                }
            }
            else
            {
                return ['message' => 'Невалидный Access Token'];
            }
        }
        else
        {
            return ['message' => 'Заполните все данные'];
        }


    }
}