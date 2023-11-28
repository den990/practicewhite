<?php

namespace frontend\models\Comments;

use common\models\AccessToken;
use common\models\Comments;
use Yii;
use yii\base\Model;

class CommentCreateForm extends Model
{
    public $accessToken;
    public $blogId;
    public $text;
    public function rules()
    {
        return [
            ['accessToken', 'required'],
            ['blogId', 'required'],
            ['text', 'required']
        ];
    }

    public function init()
    {
        $this->load(Yii::$app->request->post(), '');
    }

    public function create()
    {
        $modelComments = new Comments();
        $modelComments->blogId = $this->blogId;
        $modelComments->text = $this->text;
        $accessToken = AccessToken::find()->where(['accessToken' => $this->accessToken])->one();
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