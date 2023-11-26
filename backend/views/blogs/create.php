<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Blogs $model */

$this->title = 'Create BaseBlogs';
$this->params['breadcrumbs'][] = ['label' => 'BaseBlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blogs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
