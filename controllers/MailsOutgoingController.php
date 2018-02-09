<?php

namespace app\controllers;

use app\models\Events;
use app\models\ExecutorAuthority;
use app\models\MailsOutgoingEvents;
use app\models\MailsOutgoingUser;
use Yii;
use app\models\MailsOutgoing;
use app\models\MailsOutgoingSearch;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * MailsOutgoingController implements the CRUD actions for MailsOutgoing model.
 */
class MailsOutgoingController extends Controller
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
     * Lists all MailsOutgoing models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MailsOutgoingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MailsOutgoing model.
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
     * Creates a new MailsOutgoing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MailsOutgoing();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $model->files = UploadedFile::getInstances($model, 'files');
            if($model->save()){
                foreach ($post['executors'] as $user){
                    $mailsOutgoingUser = new MailsOutgoingUser();
                    $mailsOutgoingUser->user_id = $user;
                    $mailsOutgoingUser->mails_outgoing_id = $model->id;
                    $mailsOutgoingUser->created_at = date('Y-m-d H:i:s');
                    $mailsOutgoingUser->save();
                }
                foreach ($post['MailsOutgoing']['events'] as $event){
                    $mailsOutgoingEvents = new MailsOutgoingEvents();
                    $mailsOutgoingEvents->events_id = $event;
                    $mailsOutgoingEvents->mails_outgoing_id = $model->id;
                    $mailsOutgoingEvents->save();
                }
                if(is_array($model->files)){
                    foreach ($model->files as $key => $file){
                        $directory = Yii::getAlias('@app/web/files/out/') . DIRECTORY_SEPARATOR . $model->id . DIRECTORY_SEPARATOR;
                        if (!is_dir($directory)) {
                            FileHelper::createDirectory($directory);
                        }
                        $file->saveAs($directory. ($key+1) . '.' . $file->extension);
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        $executors = new ExecutorAuthority();
        $events = new Events();
        $count = MailsOutgoing::find()->count();
        $model->num = ($count+1).'/'.date('y');

        return $this->render('create', [
            'model' => $model,
            'data' => $executors->getExecutorsAll(),
            'events' => $events->getEventsAll(),
        ]);
    }

    /**
     * Updates an existing MailsOutgoing model.
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

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MailsOutgoing model.
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
     * Finds the MailsOutgoing model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MailsOutgoing the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MailsOutgoing::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
