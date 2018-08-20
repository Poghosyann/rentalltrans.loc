<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 2/23/2017
 * Time: 2:25 AM
 */
namespace frontend\controllers;

use app\models\Order;
use app\models\PaymentAccount;
use common\components\Helper;
use common\components\Pagination;
use common\models\Category;
use common\models\City;
use common\models\ClassItem;
use common\models\Country;
use common\models\Filter;
use common\models\Image;
use common\models\Item;
use common\models\ItemHasFilter;
use common\models\Marka;
use common\models\Model;
use common\models\Setting;
use common\models\TransmissionVehicles;
use common\models\TypeBody;
use common\models\User;
use Eventviva\ImageResize;
use frontend\models\Chat;
use Yii;
use common\controllers\AuthController;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ItemController extends AuthController
{

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function actionMyRentals($status = null)
    {
        $item = Item::find()
            ->where(['item.user_id' => Yii::$app->user->id, 'item.deleted' => 0]);

        $order_price = Yii::$app->request->get('price');
        $category_alias = Yii::$app->request->get('category');
        $categories = ArrayHelper::map(Category::find()->where(['status' => 1])->orderBy(['order' => SORT_DESC])->all(), 'alias', 'title');
        array_unshift($categories, "All Categories");

        $category = Category::findOne(['status' => 1, 'alias' => $category_alias]);

        if($order_price == 'low'){
            $order_price = SORT_ASC;
        }elseif($order_price == 'high'){
            $order_price = SORT_DESC;
        }else{
            $order_price = SORT_ASC;
        }

        if(!empty($category) ){
            $item = $item->andWhere(['item.category_id' => $category->id]);
        }

        $pageSize = Setting::findOne(2)->value;

        $query = $item;
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
        $pages->pageSizeParam = false;
        $items = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['item.price_daily' => $order_price])
            ->all();

        return $this->render('my-rentals', [
            'items' => $items,
            'pages' => $pages,
            'status' => $status,
            'categories' => $categories
        ]);
    }

    public function actionMyRentedItems(){

        $item = Order::find()->where(['item_user_id' => Yii::$app->user->id, 'status' => 1]);
        $sort = Yii::$app->request->get('date');

        if($sort == 'up'){
            $sort = SORT_DESC;
        }elseif($sort == 'down'){
            $sort = SORT_ASC;
        }else{
            $sort = SORT_DESC;
        }


        $pageSize = Setting::findOne(2)->value;

        $query = $item;
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
        $pages->pageSizeParam = false;
        $items = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['to' => $sort])
            ->all();

        $chat_model = new Chat();

        return $this->render('my-rented-items',[
            'orders' => $items,
            'pages' => $pages,
            'chat_model' => $chat_model,
        ]);

    }


    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'my-rentals' page.
     * @return mixed
     */
    public function actionAdd()
    {
        $model = new Item();
        $model->user_id = Yii::$app->user->id;
        $post = Yii::$app->request->post();
        $upload = UploadedFile::getInstances($model, 'image');

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



        $model->status = 'Draft';
        $model->publish = 0;

        if ($model->load($post) && $model->save()) {

            if (!empty($upload)) {
                $this->fileUpload($model->id, $model->category_id);
            }
            ItemHasFilter::add($post["ItemHasFilter"]['filter_id'], $model->id);

            Yii::$app->session->setFlash('success', 'Item has been saved as draft.');

            return $this->redirect(['update', 'id' => $model->id, 'category_id' => $model->category_id]);
        } else {
            return $this->render('create', [
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
    }


    /**
     * @param $id
     * @param $category_id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id, $category_id)
    {
        $model = $this->findModel($id, $category_id);
        $model->user_id = Yii::$app->user->id;
        $upload = UploadedFile::getInstances($model, 'image');
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

        if ($model->load($post)) {


            $model->save();

            if (!empty($upload)) {
                $this->fileUpload($model->id, $model->category_id);
            }
            ItemHasFilter::remove($model->id);
            ItemHasFilter::add($post["ItemHasFilter"]['filter_id'], $model->id);
            Yii::$app->session->setFlash('success', $model->publish ? 'Item has been successfully updated.' : 'Item has been saved as draft.');

            return $this->redirect(['update', 'id' => $model->id, 'category_id' => $model->category_id]);
        } else {
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
    }


    /**
     * @param $id
     * @param $category_id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id, $category_id)
    {
        $model = $this->findModel($id, $category_id);
        $model->deleted = 1;
        $model->save();

        return $this->redirect(['/user/my-items']);
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $category_id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $category_id)
    {
        if (($model = Item::findOne(['id' => $id, 'category_id' => $category_id, 'user_id' => Yii::$app->user->id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * @param $id
     * @param $category_id
     */
    public function fileUpload($id, $category_id) {

        $path = Yii::getAlias("@common/web/uploads/items/".$id);
        $new_path1 = Yii::getAlias("@common/web/uploads/items/".$id."/152-152");
        $new_path2 = Yii::getAlias("@common/web/uploads/items/".$id."/555-555");

        BaseFileHelper::createDirectory($path);
        BaseFileHelper::createDirectory($new_path1);
        BaseFileHelper::createDirectory($new_path2);

        $model = $this->findModel($id, $category_id);
        $files = UploadedFile::getInstances($model, 'image');

        foreach ($files as $file){

            $model_image = new Image();

            $symbols = '0123456789abcdefghijklmnopqrstuvwxyz';
            $filename = substr(str_shuffle($symbols), 0, 5);

            $name = 'sic-degree-rentals-'.$filename.'.'.$file->extension;

            $file->saveAs($path . DIRECTORY_SEPARATOR . $name);


            $image = $path .DIRECTORY_SEPARATOR .$name;

            $model_image->item_id = $model->id;
            $model_image->path = $name;
            $model_image->save();

            $new_name1 = $new_path1 .DIRECTORY_SEPARATOR.$name;

            $image = new ImageResize($image);
            $image->resizeToBestFit(152, 152);
            $image->crop(152, 152);
            $image->save($new_name1);

            $new_name2 = $new_path2 .DIRECTORY_SEPARATOR.$name;

            $image->resizeToBestFit(555, 555);
            $image->crop(555, 555);
            $image->save($new_name2);
        }
    }

    /**
     * @return string
     */
    public function actionRentedItems(){

        $item = Order::find()->where(['user_id' => Yii::$app->user->id, 'status' => 1]);
        $sort = Yii::$app->request->get('date');

        if($sort == 'up'){
            $sort = SORT_DESC;
        }elseif($sort == 'down'){
            $sort = SORT_ASC;
        }else{
            $sort = SORT_DESC;
        }


        $pageSize = Setting::findOne(2)->value;

        $query = $item;
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
        $pages->pageSizeParam = false;
        $items = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['to' => $sort])
            ->all();

        $chat_model = new Chat();

        return $this->render('rented-items',[
            'orders' => $items,
            'pages' => $pages,
            'chat_model' => $chat_model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionImageRemove()
    {
        if(!Yii::$app->request->isAjax){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $id = Yii::$app->request->post('id');

        $image = Image::findOne($id);
        echo json_encode([
            'success' => $image->delete(),
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionAjaxFilter(){

        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $cat_id = Yii::$app->request->post('cat_id');

        if($cat_id) {
            $filters = ArrayHelper::map(Filter::find()->joinWith(['categoryHasFilters'])->where(['category_has_filter.category_id' => $cat_id])->all(), 'id', 'title');
            echo json_encode($filters);
        }
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionAjaxModel(){

        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $mark_id = Yii::$app->request->post('mark_id');
        if($mark_id) {
            $models = ArrayHelper::map(Model::find()->where(['mark_id' => $mark_id])->all(), 'id', 'model');
            echo json_encode($models);
        }
    }

}


