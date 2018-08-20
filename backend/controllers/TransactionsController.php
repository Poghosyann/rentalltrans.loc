<?php

namespace backend\controllers;

use common\controllers\AuthController;
use Yii;
use app\models\Order;
use backend\models\orderSearch;
use yii\web\NotFoundHttpException;

/**
 * TransactionsController implements the CRUD actions for Order model.
 */
class TransactionsController extends AuthController
{

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new orderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @param integer $user_id
     * @param integer $item_user_id
     * @param integer $item_id
     * @return mixed
     */
    public function actionView($id, $user_id, $item_user_id, $item_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $user_id, $item_user_id, $item_id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'user_id' => $model->user_id, 'item_user_id' => $model->item_user_id, 'item_id' => $model->item_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $user_id
     * @param integer $item_user_id
     * @param integer $item_id
     * @return mixed
     */
    public function actionUpdate($id, $user_id, $item_user_id, $item_id)
    {
        $model = $this->findModel($id, $user_id, $item_user_id, $item_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'user_id' => $model->user_id, 'item_user_id' => $model->item_user_id, 'item_id' => $model->item_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $user_id
     * @param integer $item_user_id
     * @param integer $item_id
     * @return mixed
     */
    public function actionDelete($id, $user_id, $item_user_id, $item_id)
    {
        $this->findModel($id, $user_id, $item_user_id, $item_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $user_id
     * @param integer $item_user_id
     * @param integer $item_id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $user_id, $item_user_id, $item_id)
    {
        if (($model = Order::findOne(['id' => $id, 'user_id' => $user_id, 'item_user_id' => $item_user_id, 'item_id' => $item_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
