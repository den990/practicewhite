<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class PostListForm extends Model
{
    public $limit;
    public $offset;
    public $accessToken;

    public function rules()
    {
        return [
            [['limit', 'offset'], 'integer'],
            ['accessToken', 'string'],
        ];
    }

    public function init()
    {
        parent::init();

        // Устанавливаем дефолтные значения, если они не были переданы
        $this->loadDefaultValues();
    }

    public function loadDefaultValues()
    {
        $this->limit = $this->limit ?? Yii::$app->params['blogs.defaultLimit'];
        $this->offset = $this->offset ?? Yii::$app->params['blogs.defaultOffset'];
    }
}