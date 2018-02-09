<?php

namespace app\controllers;

use app\models\Events;
use app\models\ExecutorAuthority;
use app\models\MailsIncomingEvents;
use app\models\MailsIncomingUser;
use app\models\User;
use Yii;
use app\models\MailsIncoming;
use app\models\MailsIncomingSearch;
use yii\base\Event;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * MailsIncomingController implements the CRUD actions for MailsIncoming model.
 */
class MailsIncomingController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MailsIncoming models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MailsIncomingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MailsIncoming model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MailsIncoming model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MailsIncoming();

        if ($model->load(Yii::$app->request->post()) ) {
            $post = Yii::$app->request->post();
            $model->files = UploadedFile::getInstances($model, 'files');
            //vd($post);
            if($model->save()){
                foreach ($post['executors'] as $user){
                    $mailsIncomingUser = new MailsIncomingUser();
                    $mailsIncomingUser->user_id = $user;
                    $mailsIncomingUser->mails_incoming_id = $model->id;
                    $mailsIncomingUser->created_at = date('Y-m-d H:i:s');
                    $mailsIncomingUser->save();
                }
                foreach ($post['MailsIncoming']['events'] as $event){
                    $mailsIncomingEvents = new MailsIncomingEvents();
                    $mailsIncomingEvents->events_id = $event;
                    $mailsIncomingEvents->mails_incoming_id = $model->id;
                    $mailsIncomingEvents->save();
                }
                if(is_array($model->files)){
                    foreach ($model->files as $key => $file){
                        $directory = Yii::getAlias('@app/web/files/in/') . DIRECTORY_SEPARATOR . $model->id . DIRECTORY_SEPARATOR;
                        if (!is_dir($directory)) {
                            FileHelper::createDirectory($directory);
                        }
                        $file->saveAs($directory. ($key+1) . '.' . $file->extension);
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                vd($model->errors);
            }
        }
        //$user = new MailsIncoming();
        //vd($user->getUsersAll());
        $executors = new ExecutorAuthority();
        $events = new Events();
        $count = MailsIncoming::find()->count();
        $model->in_num = ($count+1).'/'.date('y');
        return $this->render('create', [
            'model' => $model,
            'data' => $executors->getExecutorsAll(),
            'events' => $events->getEventsAll(),
        ]);
    }

    /**
     * Updates an existing MailsIncoming model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $user = new MailsIncoming();
        $executors = $user->getUsersAll();
        return $this->render('update', [
            'model' => $model,
            'executors' => $executors,
        ]);
    }

    /**
     * Deletes an existing MailsIncoming model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MailsIncoming model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MailsIncoming the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MailsIncoming::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
