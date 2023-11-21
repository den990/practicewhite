<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\Blogs $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="blogs-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'text',
            'idUser',
            [
                'label' => 'Count Comments',
                'value' => function ($model) {
                    return $model->getComments()->count();
                },
            ],
        ],
    ]) ?>

    <h2>Comments</h2>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getComments(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'text',
            'userId',
        ],
    ]); ?>

</div>
