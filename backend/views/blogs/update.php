<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Blogs $model */

$this->title = 'Update BaseBlogs: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'BaseBlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="blogs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
