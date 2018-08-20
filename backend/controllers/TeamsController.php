<?php

namespace backend\controllers;

use common\controllers\AuthController;
use Eventviva\ImageResize;
use kotchuprik\sortable\actions\Sorting;
use Yii;
use common\models\Team;
use yii\helpers\BaseFileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * TeamsController implements the CRUD actions for Team model.
 */
class TeamsController extends AuthController
{

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'sorting' => [
                'class' => Sorting::className(),
                'query' => Team::find(),
            ],
        ];
    }

    /**
     * Displays a single Team model.
     * @param integer $id
     * @param integer $page_id
     * @return mixed
     */
    public function actionView($id, $page_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $page_id),
        ]);
    }

    /**
     * Creates a new Team model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Team();
        $model->page_id = 2;
        $upload = UploadedFile::getInstance($model, 'image');

        if ($model->load(Yii::$app->request->post())) {

            if (!empty($upload)) {
                $model->image = $upload->name;
            }

            $model->save();
            if (!empty($upload)) {
                $this->fileUpload($model->id, $model->page_id);
            }

            return $this->redirect(['/pages/update?id=2']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Team model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $page_id
     * @return mixed
     */
    public function actionUpdate($id, $page_id)
    {
        $model = $this->findModel($id, $page_id);
        $model->page_id = 2;
        $upload = UploadedFile::getInstance($model, 'image');
        $lastImage = $model->image;
        $post = Yii::$app->request->post();


        if ($model->load($post)) {
            if (!empty($upload)) {
                $model->image = $upload->name;
            } else {
                $model->image = $lastImage;
            }
            $model->save();
            if (!empty($upload)) {
                $this->fileUpload($model->id, $model->page_id);
            }
            return $this->redirect(['/pages/update?id=2']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Team model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $page_id
     * @return mixed
     */
    public function actionDelete($id, $page_id)
    {

        die;
        $this->findModel($id, $page_id)->delete();

        return $this->redirect(['/pages/update?id=2']);
    }

    /**
     * Finds the Team model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $page_id
     * @return Team the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $page_id)
    {
        if (($model = Team::findOne(['id' => $id, 'page_id' => $page_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function fileUpload($id, $page_id) {

        $path = Yii::getAlias("@common/web/uploads/teams");
        $new_path1 = Yii::getAlias("@common/web/uploads/teams/120-120");

        BaseFileHelper::createDirectory($path);
        BaseFileHelper::createDirectory($new_path1);

        $model = $this->findModel($id, $page_id);
        $file = UploadedFile::getInstance($model, 'image');

        $symbols = '0123456789abcdefghijklmnopqrstuvwxyz';
        $filename = substr(str_shuffle($symbols), 0, 16);

        $name ='rent-all-trans-'. $filename . '.' . $file->extension;
        $file->saveAs($path . DIRECTORY_SEPARATOR . $name);

        $image = $path .DIRECTORY_SEPARATOR .$name;

        $model->image = $name;
        $model->save();

        $new_name1 = $new_path1 .DIRECTORY_SEPARATOR.$name;

        $image = new ImageResize($image);
        $image->resizeToBestFit(120, 120);
        $image->crop(120, 120);
        $image->save($new_name1);
    }
}
