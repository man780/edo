<?php

namespace app\controllers;

use app\models\Events;
use app\models\ExecutorAuthority;
use app\models\MailsIncomingEvents;
use app\models\MailsIncomingMailsOutgoing;
use app\models\MailsIncomingUser;
use app\models\User;
use Yii;
use app\models\MailsIncoming;
use app\models\MailsIncomingSearch;
use yii\base\Event;
use yii\filters\AccessControl;
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
        $model = $this->findModel($id);

        foreach($model->users as $user){
            if($user->id == Yii::$app->user->id && $model->status == null){
                $model->status = 1;
                $mailsUser = MailsIncomingUser::find()->where(['user_id' => $user->id, 'mails_incoming_id' => $model->id])->one();
                $mailsUser->is_viewed = 1;
                if($mailsUser->save() && $model->save()){
                    break;
                }else{
                    vd([$model->errors, $mailsUser->errors]);
                }
            }elseif ($user->id == Yii::$app->user->id){
                $mailsUser = MailsIncomingUser::find()->where(['user_id' => $user->id, 'mails_incoming_id' => $model->id])->one();
                $mailsUser->is_viewed = 1;
                if($mailsUser->save() ){
                    break;
                }else{
                    vd($mailsUser->errors);
                }
            }
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Do a single MailsIncoming model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDone($id)
    {
        $model = $this->findModel($id);

        //Проверка на сделано
        $flag = 0;
        foreach ($model->mailsIncomingUsers as $user){
            if(Yii::$app->user->id == $user->user_id){
                $flag++;
            }
        }
        if ($flag < count($model->mailsIncomingUsers)){
            throw new \yii\web\HttpException(403, 'Сизда бу амални бажариш учун доступ йўқ!');
        }

        if ($model->load(Yii::$app->request->post()) ) {
            $model->status = 2;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                vd($model->errors);
            }
        }

        return $this->render('done', [
            'model' => $model,
        ]);
    }

    /**
     * Confirms a single MailsIncoming model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionConfirm($id)
    {
        if (Yii::$app->user->id != 3){
            throw new \yii\web\HttpException(403, 'Сизда бу амални бажариш учун доступ йўқ!');
        }

        $model = $this->findModel($id);
        $model->status = 3;
        if($model->save()){
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            vd($model->errors);
        }

    }

    /**
     * Creates a new MailsIncoming model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->id != 2){
            throw new \yii\web\HttpException(403, 'Сизда бу амални бажариш учун доступ йўқ!');
        }
        $model = new MailsIncoming();

        if ($model->load(Yii::$app->request->post()) ) {
            $post = Yii::$app->request->post();
            $model->files = UploadedFile::getInstances($model, 'files');
            //vd($post);
            if($model->save()){
                if(is_array($post['executors']))
                foreach ($post['executors'] as $user){
                    $mailsIncomingUser = new MailsIncomingUser();
                    $mailsIncomingUser->user_id = $user;
                    $mailsIncomingUser->mails_incoming_id = $model->id;
                    $mailsIncomingUser->created_at = date('Y-m-d H:i:s');
                    $mailsIncomingUser->save();
                }
                if(is_array($post['MailsIncoming']['events']))
                foreach ($post['MailsIncoming']['events'] as $event){
                    $mailsIncomingEvents = new MailsIncomingEvents();
                    $mailsIncomingEvents->events_id = $event;
                    $mailsIncomingEvents->mails_incoming_id = $model->id;
                    $mailsIncomingEvents->save();
                }
                if (is_array($post['MailsIncoming']['mailOutgoing']))
                    foreach ($post['MailsIncoming']['mailOutgoing'] as $mailOut){
                        $mailsInOut = new MailsIncomingMailsOutgoing();
                        $mailsInOut->mails_incoming_id = $model->id;
                        $mailsInOut->mails_outgoing_id = $mailOut;
                        $mailsInOut->direction = 2;
                        $mailsInOut->save();
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
        throw new \yii\web\HttpException(403, 'Сизда бу амални бажариш учун доступ йўқ!');

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
