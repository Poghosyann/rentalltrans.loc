<?php

namespace backend\controllers;

use common\components\Helper;
use common\controllers\AuthController;
use Yii;
use common\models\Video;
use yii\data\ActiveDataProvider;
use yii\helpers\BaseFileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * VideosController implements the CRUD actions for Video model.
 */
class VideosController extends AuthController
{
    /**
     * Lists all Video models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->orderBy(['id' => SORT_ASC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Video model.
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
     * Creates a new Video model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Video();
        $upload = UploadedFile::getInstance($model, 'upload_video');
        if ($model->load(Yii::$app->request->post())) {

            if (!empty($upload)) {
                $model->url = '/uploads/videos/'.$upload->name;
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
     * Updates an existing Video model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $upload = UploadedFile::getInstance($model, 'upload_video');
        if ($model->load(Yii::$app->request->post())) {

            if (!empty($upload)) {
                $model->url = '/uploads/videos/'.$upload->name;
                $this->fileUpload($model->id);
            }
            $model->save();

            Yii::$app->session->setFlash('success', 'Updated.');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Video model.
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
     * Finds the Video model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Video the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     */
    public function fileUpload($id) {

        $path = Yii::getAlias("@common/web/uploads/videos");
        BaseFileHelper::createDirectory($path);

        $model = $this->findModel($id);
        $file = UploadedFile::getInstance($model, 'upload_video');
        $file->saveAs($path . DIRECTORY_SEPARATOR . $file->name);
    }
}
