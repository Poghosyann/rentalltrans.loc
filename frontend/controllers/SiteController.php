<?php
namespace frontend\controllers;

use common\components\Helper;
use common\models\Category;
use common\models\Page;
use common\models\Slider;
use common\models\User;
use common\models\Video;
use DOMDocument;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;
use yii\web\View;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $sliders = Slider::find()->where(['active' => 1])->orderBy(['order' => SORT_ASC])->all();
        $categories = Category::find()->where(['status' => 1])->orderBy(['order' => SORT_ASC])->all();

        return $this->render('index', [
            'sliders' => $sliders,
            'categories' => $categories,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
        	$isLoginUrl = Yii::$app->session->get('isLogin_Url');
	        if (!empty($isLoginUrl)){
		        return $this->redirect($isLoginUrl, 301);
	        }
            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContacts()
    {
        $model = new ContactForm();
        $page = Page::findOne(['alias' => 'contacts']);
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->validate()) {

            if($post['ContactForm']['type'] == 'Listing an Item'){
                $email = Yii::$app->params['adminEmail'];
            }elseif($post['ContactForm']['type'] == 'Renting an Item'){
                $email = Yii::$app->params['adminEmail'];
            }elseif ($post['ContactForm']['type'] == 'My Account'){
                $email = 'myaccount@rentalltrans.com';
            }elseif ($post['ContactForm']['type'] == 'Refunds'){
                $email = 'refunds@rentalltrans.com';
            }elseif ($post['ContactForm']['type'] == 'Report Service Abuse'){
                $email = 'abuse@rentalltrans.com';
            }elseif ($post['ContactForm']['type'] == 'Site Feedback'){
                $email = Yii::$app->params['adminEmail'];
            }else{
                $email = Yii::$app->params['adminEmail'];
            }


            if ($model->sendEmail($email)) {
                $param = 'Thank you for contacting us. We will respond to you as soon as possible.';
            } else {
                $param = 'There was an error sending your message.';
            }

            return $this->render('contact-send', [
                'param' => $param,
            ]);

        } else {
            return $this->render('contact', [
                'model' => $model,
                'page' => $page,
            ]);
        }
    }


    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPage($alias)
    {

        $page = Page::findOne(['alias' => $alias]);

        if(!$page){
            throw new NotFoundHttpException('404');
        }

        return $this->render('page', [
            'page' => $page
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {

                if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                    $param =  'Activation code sent to written email';
                } else {
                    $param = 'Sorry, we are unable to activation for email provided.';
                }

                return $this->render('active', [
                    'param' => $param,
                ]);
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /**
     * @param $token
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionActivateAccount($token)
    {
        $model = User::findOne(['activate_token' => $token]);

        if(!$model){
            throw new NotFoundHttpException('404');
        }

        $param = [
            'email' => $model->email,
            'first_name' => $model->first_name,
            'last_name' => $model->last_name,
            'member' => 1,
        ];

        $model->activate_token = NULL;
        $model->status = User::STATUS_ACTIVE;
        $model->save();

        if (Yii::$app->user->login($model)){
	        return $this->redirect('/');
        }

        return $this->redirect('/login');
    }

    /**
     * @param $token
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionActivateEmail($token)
    {
        $model = User::findOne(['activate_token' => $token]);
        if(!$model){
            throw new NotFoundHttpException('404');
        }
        $model->activate_token = NULL;
        $model->email = $model->change_email;
        $model->save();

        return $this->redirect('/user/settings');
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                $param = 'We just sent you an email with password the reset link to your email address. Please find the email and click the link to reset your password.';
                return $this->render('forgot-password', [
                    'param' => $param,
                ]);
            } else {
                $param = 'Sorry, we are unable to reset password for the provided email address.';
                return $this->render('forgot-password', [
                    'param' => $param,
                ]);
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {

            return $this->redirect('/login');
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    /****
     *  HTML
     ***/
    public function  actionServerErr(){
        return $this->render('server-err');
    }


}
