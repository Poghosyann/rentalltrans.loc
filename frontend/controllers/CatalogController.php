<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 3/1/2017
 * Time: 12:13 PM
 */
namespace frontend\controllers;

use common\components\Helper;
use common\components\Pagination;
use common\components\Session;
use common\models\Category;
use common\models\ClassItem;
use common\models\CompanyProduct;
use common\models\Connection;
use common\models\Item;
use common\models\Marka;
use common\models\Model;
use common\models\OrderHasCompanyProduct;
use common\models\Page;
use common\models\Setting;
use common\models\User;
use DateInterval;
use DateTime;
use frontend\models\Chat;
use frontend\models\RentDate;
use frontend\models\RentPrice;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class CatalogController extends Controller{

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
     * @param $category
     * @param $location_from
     * @param $location_to
     * @param $from
     * @param $to
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($category, $location_from, $location_to, $from, $to,$from_h,$from_i, $to_h, $to_i, $price = null, $user = null, $class = null, $marka = null, $model = null)
    {
	    Yii::$app->db->createCommand(
		    "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"
	    );

	    /*$results_company = Yii::$app->db->createCommand(
		    "SELECT * FROM `order_has_company_product` WHERE `order_id`= 160;"
	    )->queryAll();

            foreach ($results_company as $result_company){
	            $result_product = Yii::$app->db->createCommand(
		            "SELECT * FROM `company_product` WHERE `id`= ".$result_company['company_product_id'].";"
	            )->queryOne();

	            echo '<p> '.$result_product['name'].' <span style="float: right">включая налоги AMD '.$result_product['price'].'</span></p><hr>';
            }*/


        $from = str_replace('-', '/', $from);
        $to = str_replace('-', '/', $to);

        $startDate = new DateTime($from);
        $endDate = new DateTime($to);
        $interval = $startDate->diff($endDate);

        $days = $interval->days == 0 ? 1 : $interval->days;
        $session = Yii::$app->session;

        if($session->isActive){

            $item_session = [
                'location_from' => $location_from,
                'location_to' => $location_to,
                'from' => $from,
                'to' => $to,
                'from_h' => $from_h,
                'from_i' => $from_i,
                'to_h' => $to_h,
                'to_i' => $to_i,
                'days' => $days,
            ];
            Yii::$app->session->set('rent-now', $item_session);
        }

        $item = Item::find()
	        ->select(('item.*'))
            ->joinWith(['user', 'order'])
	        ->where(['user.status' => User::STATUS_ACTIVE,'item.status' => 'available', 'item.deleted' => 0])
	        ->andWhere(['user.hide_items' => 0])
	        ->groupBy('item.id');

        $categories = Category::findOne(['status' => 1, 'alias' => $category]);
        $user_item = User::findOne(['username' => $user]);
        $class_item = ClassItem::findOne($class);
        $mark_item = Marka::findOne($marka);
        $model_item = Model::findOne($model);

        if(empty($categories) && ($category != 'all')) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }elseif(!empty($categories) ){
            $item = $item->andWhere(['category_id' => $categories->id]);
        }

        if(empty($user_item) && ($user != '-')) {
            if(!empty($user)) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }elseif(!empty($user_item) ){
            $item = $item->andWhere(['user_id' => $user_item->id]);
        }

        if(empty($class_item) && ($class != '-')) {
            if(!empty($class)){
                throw new NotFoundHttpException('The requested page does not exist.');
            }

        }elseif(!empty($class_item) ){
            $item = $item->andWhere(['class_id' => $class_item->id]);
        }

        if(empty($mark_item) && ($marka != '-')) {
            if(!empty($marka)){
                throw new NotFoundHttpException('The requested page does not exist.');
            }

        }elseif(!empty($mark_item) ){
            $item = $item->andWhere(['mark_id' => $mark_item->id]);
        }

        if(empty($mark_item) && ($model != '-')) {
            if(!empty($model)){
                throw new NotFoundHttpException('The requested page does not exist.');
            }

        }elseif(!empty($model_item) ){
            $item = $item->andWhere(['model_id' => $model_item->id]);
        }

        $query = $item;
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 50]);
        $pages->pageSizeParam = false;
        $items = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['price_daily' => ($price ==  'high') ? SORT_DESC : SORT_ASC])
            ->all();

        return $this->render('index', [
            'items' => $items,
            'pages' => $pages,
            'categories' => $categories,
            'days' => $days,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionSearch(){

        $post = Yii::$app->request->post();
        if($post)
        {
            $from = str_replace('/', '-', $post['RentDate']['from']);
            $to = str_replace('/', '-', $post['RentDate']['to']);

            $search_uri = Html::encode($post['RentDate']['categories']).
                '/'.Html::encode($post['RentDate']['from_location']).
                '/'.Html::encode($post['RentDate']['to_location']).
                '/'.Html::encode($from).
                '/'.Html::encode($to).
                '/'.Html::encode($post['RentDate']['from_h']).
                '/'.Html::encode($post['RentDate']['from_i']).
                '/'.Html::encode($post['RentDate']['to_h']).
                '/'.Html::encode($post['RentDate']['to_i']);

            if(!empty($post['RentDate']['price']) || !empty($post['RentDate']['user']) || !empty($post['RentDate']['class']) || !empty($post['RentDate']['marka']) || !empty($post['RentDate']['model']) ) {
                $search_uri = Html::encode($post['RentDate']['categories']) .
                    '/' . Html::encode($post['RentDate']['from_location']) .
                    '/' . Html::encode($post['RentDate']['to_location']) .
                    '/' . Html::encode($from) .
                    '/' . Html::encode($to) .
                    '/' . Html::encode($post['RentDate']['from_h']).
                    '/' . Html::encode($post['RentDate']['from_i']).
                    '/' . Html::encode($post['RentDate']['to_h']).
                    '/' . Html::encode($post['RentDate']['to_i']).
                    '/' . Html::encode(!empty($post['RentDate']['price']) ? $post['RentDate']['price'] : '-').
                    '/' . Html::encode(!empty($post['RentDate']['user']) ? $post['RentDate']['user'] : '-').
                    '/' . Html::encode(!empty($post['RentDate']['class']) ? $post['RentDate']['class'] : '-').
                    '/' . Html::encode(!empty($post['RentDate']['marka']) ? $post['RentDate']['marka'] : '-').
                    '/' . Html::encode(!empty($post['RentDate']['model']) ? $post['RentDate']['model'] : '-');
            }
            $this->redirect('/browse/'.$search_uri);
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionItemPage($alias){

	    if (Yii::$app->user->isGuest){
		    $session = Yii::$app->session;
		    $url = Yii::$app->request->url;
		    if($session->isActive){
			    Yii::$app->session->set('isLogin_Url', $url);
		    }
	    }
        $item = Item::find()->joinWith('user')->where(['item.id' => $alias, 'user.hide_items' => 0])->one();

        $additional_products1 = CompanyProduct::find()->where(['status' => 1, 'type' => 1])->orderBy(['order' => SORT_ASC])->all();
        $additional_products2 = CompanyProduct::find()->where(['status' => 1, 'type' => 2])->orderBy(['order' => SORT_ASC])->all();
        $additional_products3 = CompanyProduct::find()->where(['status' => 1, 'type' => 3])->orderBy(['order' => SORT_ASC])->all();

        $site_terms = Page::findOne(3);
        $privacy_policy = Page::findOne(4);
        $session = Yii::$app->session;
        $model_rent_price = new RentPrice();
        $session_rent = Yii::$app->session->get('rent-now');

        if(empty($item) OR empty($session_rent['location_from'])){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if($item->price_weekly && $session_rent['days'] >= 7 && $session_rent['days'] <= 10){
			 $total_price = $session_rent['days'] * $item->price_weekly;
        }elseif ($item->price_3_days && $session_rent['days'] >= 4 && $session_rent['days'] <= 6){
	        $total_price = $session_rent['days'] * $item->price_3_days;
        }elseif ($item->price_daily){
            $total_price = $session_rent['days'] * $item->price_daily;
        }

        if($session->isActive){

            $item_session = [
                'location_from' => $session_rent['location_from'],
                'location_to' => $session_rent['location_to'],
                'from' => $session_rent['from'],
                'to' => $session_rent['to'],
                'from_h' => $session_rent['from_h'],
                'from_i' => $session_rent['from_i'],
                'to_h' => $session_rent['to_h'],
                'to_i' => $session_rent['to_i'],
                'days' => $session_rent['days'],
                'item_user_id' => $item->user_id,
                'id' => $item->id,
                'total_price' => $total_price,
            ];
            Yii::$app->session->set('rent-now', $item_session);
        }
        

        return $this->render('item-page', [
            'item' => $item,
            'total_price' => $total_price,
            'session_rent' =>  $session_rent,
            'model_rent_price' => $model_rent_price,
            'additional_products1' => $additional_products1,
            'additional_products2' => $additional_products2,
            'additional_products3' => $additional_products3,
            'site_terms' => $site_terms,
            'privacy_policy' => $privacy_policy,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionAjaxDate(){

        if(!Yii::$app->request->isAjax){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $id = Yii::$app->request->post('id');
        $total_price = 0;
        $item = Item::findOne($id);

        $start = Yii::$app->request->post('start');
        $end = Yii::$app->request->post('end');

        $startDate = new DateTime($start);
        $endDate = new DateTime($end);
        $interval = $startDate->diff($endDate);
        $days = $interval->days == 0 ? 1 : $interval->days;

        $session = Yii::$app->session;
        Yii::$app->session->get('rent-now');

        if($item->price_weekly && $days <= 10  && $days >= 7){
            $total_price = $days * $item->price_weekly;
        }elseif ($item->price_3_days && $days <= 6  && $days >= 4 ){
            $total_price = $days * $item->price_3_days;
        }elseif ($item->price_daily){
            $total_price = $days * $item->price_daily;
        }

        if($session->isActive){

            $item_session = [
                'id' => $id,
                'from' => $start,
                'to' => $end,
                'total' => $days,
                'total_price' => $total_price,
                'item_user_id' => $item->user_id,
                'url' => '/messages/'.$item->user->username,
            ];
            Yii::$app->session->set('rent-now', $item_session);

        }

        if($start == $end){
            $end = new DateTime($start);
            $end->add(new DateInterval('P1D'));
            $end = $end->format('m/d/Y') ;
        }

        echo json_encode([
            'total_price' => $total_price,
            'end' => $end,
        ]);

    }

}