<?php

use common\models\BaseBlogs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'BaseBlogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blogs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create BaseBlogs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'text',
            'idUser',
            [
                'label' => 'Comments',
                'value' => function ($model) {
                    return $model->getComments()->count();
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, BaseBlogs $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
