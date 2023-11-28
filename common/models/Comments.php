<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Blogs;

/**
 * Comments model
 *
 * @property integer $id
 * @property string $text
 * @property integer $userId
 * @property integer $blogId

 */

class Comments extends BaseComments
{
    public function rules()
    {
        return parent::rules();
    }
}