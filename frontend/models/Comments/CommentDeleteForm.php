<?php

namespace frontend\models\Comments;

use Yii;
use common\models\Comments;
use yii\base\Model;
use common\models\AccessToken;

class CommentDeleteForm extends Model
{
    public $commentId;
    public $accessToken;

    public function rules()
    {
        return [
            [['commentId', 'accessToken'], 'required'],
        ];
    }

    public function init()
    {
        $this->load(Yii::$app->request->post(), '');
    }

    public function delete()
    {
        if (Yii::$app->request->isPost) {
            $comment = Comments::findOne($this->commentId);
            $accessToken = AccessToken::find()->where(['accessToken' => $this->accessToken])->one();
            if ($accessToken) {
                if (!$comment) {
                    return ['message' => 'Комментарий не найден'];
                }

                if ($comment->delete()) {
                    return ['message' => 'Комментарий успешно удален'];
                } else {
                    return ['message' => 'Ошибка удаления комментария'];
                }
            }
            else
            {
                return ['message' => 'Нет такого токена'];
            }
        }
    }
}