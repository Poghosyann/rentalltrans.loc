<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 2/16/2017
 * Time: 2:28 PM
 */

namespace frontend\controllers;


use common\models\City;
use common\models\Country;
use Eventviva\ImageResize;
use frontend\models\AdditionalSettingsForm;
use frontend\models\ChangeEmailForm;
use frontend\models\ChangePasswordForm;
use frontend\models\PersonalInformationForm;
use frontend\models\User;
use Yii;
use common\controllers\AuthController;
use yii\helpers\BaseFileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class UserController extends AuthController
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
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Eventviva\ImageResizeException
     * @throws \yii\base\Exception
     */
    public function actionEditProfile()
    {
        $model = $this->findModel();
        $post = Yii::$app->request->post();
        $upload = UploadedFile::getInstance($model, 'image');
        $lastImage = $model->image;
        $countries = Country::find()->where(['id' => 7])->all();
        $cities = City::find()->where(['country_id' => 7])->all();

        if ($model->load($post)) {

            if (!empty($upload)) {
                $model->image = $upload->name;
            } else {
                $model->image = $lastImage;
            }

            $model->save();

            if (!empty($upload)) {
                $this->fileUpload();
            }

            Yii::$app->session->setFlash('success', 'Updated.');

            return $this->redirect(['/user/edit-profile']);
        } else {

            return $this->render('edit-profile', [
                'model' => $model,
                'countries' => $countries,
                'cities' => $cities,
            ]);
        }
    }


    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSettings(){

        $change_password = new ChangePasswordForm();
        $hideItems = new PersonalInformationForm();
        $additional_settings = new AdditionalSettingsForm();
        $change_email = new ChangeEmailForm();

        $changePassword = Yii::$app->request->post('change-password');
        $personal_information = Yii::$app->request->post('personal-information');
        $additional_setting = Yii::$app->request->post('additional-settings');
        $changeEmail = Yii::$app->request->post('change-email');

        if(!empty($changePassword)){
            if($change_password->load(Yii::$app->request->post())){
                $change_password->changepassword();
            }
        }

        if(!empty($personal_information)){

            if($hideItems->load(Yii::$app->request->post()) && $hideItems->personalInformation()){
                $this->refresh();
            }
        }
        if(!empty($additional_setting)){

            if($additional_settings->load(Yii::$app->request->post())){
                $additional_settings->notificationsEmail();
            }
        }

        if(!empty($changeEmail)){

            if($change_email->load(Yii::$app->request->post())){
                $change_email->saveEmail();
            }
        }

        $user = $this->findModel();

        return $this->render('settings', [
            'user' => $user,
            'change_password' => $change_password,
            'hideItems' => $hideItems,
            'additional_settings' => $additional_settings,
            'change_email' => $change_email,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * Your userID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        if (($model = User::findOne(Yii::$app->user->id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * @throws NotFoundHttpException
     * @throws \Eventviva\ImageResizeException
     * @throws \yii\base\Exception
     */
    public function fileUpload() {

        $path = Yii::getAlias("@common/web/uploads/users");
        $new_path1 = Yii::getAlias("@common/web/uploads/users/115-115");

        BaseFileHelper::createDirectory($path);
        BaseFileHelper::createDirectory($new_path1);
        $model = $this->findModel();
        $file = UploadedFile::getInstance($model, 'image');

        $name = 'rent-all-trans-' . $model->username . '.' . $file->extension;
        $file->saveAs($path . DIRECTORY_SEPARATOR . $name);

        $image = $path . DIRECTORY_SEPARATOR . $name;

        $model->image = $name;
        $model->save();

        $new_name1 = $new_path1 . DIRECTORY_SEPARATOR . $name;

        $image = new ImageResize($image);
        $image->resizeToBestFit(115, 115);
        $image->crop(115, 115);
        $image->save($new_name1);

    }
}