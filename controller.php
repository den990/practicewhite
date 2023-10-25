<?php
namespace common\models;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

try {
    $authKey = Yii::$app->security->generateRandomString();
    var_dump($authKey);
} catch (\yii\base\Exception $e) {
}
