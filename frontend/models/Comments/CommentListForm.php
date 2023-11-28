<?php

namespace frontend\models\Comments;

use common\models\Comments;
use Yii;
use yii\base\Model;

class CommentListForm extends Model
{
    public $blogId;
    public $comments;

    public function rules()
    {
        return [
            ['blogId', 'required'],
        ];
    }

    public function init()
    {
        $this->load(Yii::$app->request->post(), '');
    }

    public function getCommentsList()
    {
        $comments = Comments::find()->where(['blogId' => $this->blogId])->all();
        return $comments;
    }

    public function serialize()
    {
        $result = [];

        foreach ($this->comments as $comment) {
            $model = new Comments($comment);
            $result[] = $model->shortSerialize();
        }

        return $result;
    }

}