<?php

namespace backend\controllers;

use common\controllers\AuthController;
use common\models\Team;
use Eventviva\ImageResize;
use kotchuprik\sortable\actions\Sorting;
use Yii;
use common\models\Page;
use yii\data\ActiveDataProvider;
use yii\helpers\BaseFileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * PagesController implements the CRUD actions for Page model.
 */
class PagesController extends AuthController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'sorting' => [
                'class' => Sorting::className(),
                'query' => Page::find(),
            ],
        ];
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Page::find()->orderBy(['order' => SORT_ASC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();
        $upload = UploadedFile::getInstance($model, 'image');

        if ($model->load(Yii::$app->request->post())) {

            if (!empty($upload)) {
                $model->image = $upload->name;
            }

            $model->save();
            if (!empty($upload)) {
                $this->fileUpload($model->id);
            }
            Yii::$app->session->setFlash('success', 'Create.');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $upload = UploadedFile::getInstance($model, 'image');
        $lastImage = $model->image;
        $post = Yii::$app->request->post();

        $dataProvider = new ActiveDataProvider([
            'query' => Team::find()->orderBy(['order' => SORT_ASC]),
        ]);


        if ($model->load($post)) {
            if (!empty($upload)) {
                $model->image = $upload->name;
            } else {
                $model->image = $lastImage;
            }
            $model->save();
            if (!empty($upload)) {
                $this->fileUpload($model->id);
            }

            Yii::$app->session->setFlash('success', 'Updated.');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function fileUpload($id) {

        $path = Yii::getAlias("@common/web/uploads/contacts");

        BaseFileHelper::createDirectory($path);

        $model = $this->findModel($id);
        $file = UploadedFile::getInstance($model, 'image');

        $symbols = '0123456789abcdefghijklmnopqrstuvwxyz';
        $filename = substr(str_shuffle($symbols), 0, 16);

        $name ='rentalltrans-'. $filename . '.' . $file->extension;
        $file->saveAs($path . DIRECTORY_SEPARATOR . $name);

        $model->image = '/uploads/contacts/'.$name;
        $model->save();

    }
}
