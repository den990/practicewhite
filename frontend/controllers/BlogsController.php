<?php

namespace frontend\controllers;

use frontend\models\Blogs;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BlogsController implements the CRUD actions for Blogs model.
 */
class BlogsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControlForGii::class,
                    'only' => ['index', 'create', 'update', 'delete'], // Добавьте нужные действия
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['1'], // Роль для администратора
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Blogs models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Blogs::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blogs model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blogs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Blogs();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Blogs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Blogs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blogs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Blogs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blogs::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public $enableCsrfValidation = false;
    public function actionPublish() {
        $request = Yii::$app->getRequest();
        $accessToken = $request->getBodyParam('access_token');
        $text = $request->getBodyParam('text');
        if ($accessToken && $text)
        {
            $modelBlogs = new Blogs();
            $modelAccessToken = AccessesToken::find()->where(['accessToken' => $accessToken])->one();
            if ($modelAccessToken) {
                $modelBlogs->text = $text;
                $modelBlogs->idUser = $modelAccessToken->getUserId();
                if ($modelBlogs->save()) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['message' => 'Пост сохранён'];
                } else {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['message' => 'Произошла ошибка при сохранении'];
                }
            }
            else
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['message' => 'Невалидный Access Token'];
            }
        }
        else
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['message' => 'Заполните все данные'];
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
