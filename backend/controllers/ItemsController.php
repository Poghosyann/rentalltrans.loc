<?php

namespace backend\controllers;

use common\components\Helper;
use common\controllers\AuthController;
use common\models\City;
use common\models\ClassItem;
use common\models\Country;
use common\models\ItemHasFilter;
use common\models\Marka;
use common\models\TransmissionVehicles;
use common\models\TypeBody;
use Yii;
use common\models\Item;
use yii\data\ActiveDataProvider;
use yii\helpers\BaseFileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ItemsController implements the CRUD actions for Item model.
 */
class ItemsController extends AuthController
{


    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Item::find()->where(['deleted' => 0])->orderBy(['id' => SORT_DESC]),
        ]);



        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param $id
     * @param $category_id
     * @param $user_id
     * @param $country_id
     * @param $city_id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id, $category_id, $user_id, $country_id, $city_id)
    {
        $model = $this->findModel($id, $category_id, $user_id, $country_id, $city_id);

        $upload = UploadedFile::getInstances($model, 'image_main');
        $post = Yii::$app->request->post();

        $countries = Country::find()->where(['id' => 7])->all();
        $cities = City::find()->where(['country_id' => 7])->all();
        $item_class = ClassItem::find()->orderBy(['order' => SORT_ASC])->all();
        $marka = Marka::find()->all();

        $year = [];
        for ($i = 1990; $i <= date('Y'); $i++){
            $year[$i] = $i;
        }
        $transmission_vehicles = TransmissionVehicles::find()->orderBy(['order' => SORT_ASC])->all();
        $type_body = TypeBody::find()->orderBy(['order' => SORT_ASC])->all();
        $default_image = $model->image_main;

        if ($model->load($post)) {

            if ($post['Item']['publish'] == 1){
                $model->status = 'Available';
            }else{
                $model->status = 'Draft';
            }
            $model->image_main = $default_image;
            if (!empty($upload)) {
                $path = Yii::getAlias("@common/web/uploads/item");
                BaseFileHelper::createDirectory($path);
                $file = UploadedFile::getInstance($model, 'image_main');

                $symbols = '0123456789abcdefghijklmnopqrstuvwxyz';
                $filename = substr(str_shuffle($symbols), 0, 16);

                $name ='rentalltrans-'. $filename . '.' . $file->extension;
                $file->saveAs($path . DIRECTORY_SEPARATOR . $name);

                $model->image_main = $name;
            }

            $model->save();

            ItemHasFilter::remove($model->id);
            ItemHasFilter::add($post["ItemHasFilter"]['filter_id'], $model->id);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'countries' => $countries,
            'cities' => $cities,
            'item_class' => $item_class,
            'marka' => $marka,
            'year' => $year,
            'transmission_vehicles' => $transmission_vehicles,
            'type_body' => $type_body,
        ]);
    }


    /**
     * @param $id
     * @param $category_id
     * @param $user_id
     * @param $country_id
     * @param $city_id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id, $category_id, $user_id, $country_id, $city_id)
    {
        $model = $this->findModel($id, $category_id, $user_id, $country_id, $city_id);
        $model->deleted = 1;
        $model->update();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $category_id
     * @param integer $user_id
     * @param integer $country_id
     * @param integer $city_id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $category_id, $user_id, $country_id, $city_id)
    {
        if (($model = Item::findOne(['id' => $id, 'category_id' => $category_id, 'user_id' => $user_id, 'country_id' => $country_id, 'city_id' => $city_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
