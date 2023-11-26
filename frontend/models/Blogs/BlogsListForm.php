<?php

namespace frontend\models\Blogs;

use common\models\Blogs;
use common\models\User;
use Yii;
use yii\base\Model;

class BlogsListForm extends Model
{
    public $limit;
    public $offset;
    public $accessToken;
    public $blogs;

    public function rules()
    {
        return [
            [['limit', 'offset'], 'integer'],
            ['accessToken', 'string'],
        ];
    }

    public function init()
    {
        $this->limit = Yii::$app->request->get()['limit'] ?? Yii::$app->params['blogs.defaultLimit'];
        $this->offset = Yii::$app->request->get()['offset'] ?? Yii::$app->params['blogs.defaultOffset'];
        $this->accessToken = Yii::$app->request->get()['access_token'] ?? '';
    }

    public function getBlogsList()
    {
        if ($this->accessToken)
        {
            $user = User::getUserByAccessToken($this->accessToken);
            return $user->getBlogs()
                ->limit($this->limit)
                ->offset($this->offset)
                ->all();
        }
        else
        {
            return Blogs::find()
                ->limit($this->limit)
                ->offset($this->offset)
                ->all();
        }
    }

    public function serialize()
    {
        $result = [];

        foreach ($this->blogs as $blog)
        {
            $result[] = $this->shortSerialize($blog);
        }
        return $result;
    }

    public function shortSerialize($blog)
    {
        return [
            'id' => $blog['id'],
            'text' => $blog['text']
        ];
    }

    public function longSerialize($blog)
    {
        return [
            'id' => $blog['id'],
            'text' => $blog['text'],
            'userId' => $blog['idUser']
        ];
    }

}