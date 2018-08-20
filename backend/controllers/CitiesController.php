<?php

namespace backend\controllers;

use common\controllers\AuthController;
use Yii;
use common\models\City;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * CitiesController implements the CRUD actions for City model.
 */
class CitiesController extends AuthController
{
    /**
     * Lists all City models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => City::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single City model.
     * @param integer $id
     * @param integer $country_id
     * @return mixed
     */
    public function actionView($id, $country_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $country_id),
        ]);
    }

    /**
     * Creates a new City model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new City();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'country_id' => $model->country_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing City model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $country_id
     * @return mixed
     */
    public function actionUpdate($id, $country_id)
    {
        $model = $this->findModel($id, $country_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'country_id' => $model->country_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing City model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $country_id
     * @return mixed
     */
    public function actionDelete($id, $country_id)
    {
        $this->findModel($id, $country_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the City model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $country_id
     * @return City the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $country_id)
    {
        if (($model = City::findOne(['id' => $id, 'country_id' => $country_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
