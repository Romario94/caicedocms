<?php

namespace backend\controllers;

use Yii;
use common\models\Noticia;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NoticiaController implements the CRUD actions for Noticia model.
 */
class NoticiaController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'create', 'update', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'create', 'update', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['marc'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Noticia models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Noticia::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Noticia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Noticia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Noticia();

        if ($model->load(Yii::$app->request->post())) {
            $imagen = $model->uploadImage();
            // print_r($documento);die;
            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($imagen !== false) {
                    $path = $model->getImageFile();

                    $imagen->saveAs($path);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo guardar');
                // ERROR --->
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Noticia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionUpdate($id) {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                        'model' => $model,
//            ]);
//        }
//    }
    public function actionUpdate($id) {
        $Noticia = Noticia::findOne(['created_by' => Yii::$app->user->identity]);



        if (isset($Noticia) || Yii::$app->user->can('admin')) {
            $model = $this->findModel($id);
            $oldFile = $model->getImageFile();

            $oldImage = $model->imagen;


            if (!isset($oldFile) && !isset($oldImage)) {
                if ($model->load(Yii::$app->request->post())) {

                    $image = $model->uploadImage();

                    // revert back if no valid file instance uploaded
                    if ($image === false) {
                        $model->imagen = $oldImage;
                        //$model->filename = $oldFileName;
                    }
                    if ($model->save()) {
                        // upload only if valid uploaded file instance found
                        if ($image !== false && unlink($oldFile)) { // delete old and overwrite
                            $path = $model->getImageFile();
                            $image->saveAs($path);
                        }
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        // error in saving model
                        return $this->render('update', [
                                    'model' => $model,
                        ]);
                    }


                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->render('update', [
                                'model' => $model,
                    ]);
                }
            } else {


                if ($model->load(Yii::$app->request->post())) {

                    $imagen = $model->uploadImage();
                    // print_r($documento);die;
                    if ($model->save()) {
                        // upload only if valid uploaded file instance found
                        if ($imagen !== false) {
                            $path = $model->getImageFile();

                            $imagen->saveAs($path);
                        }
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        // ERROR --->
                        return $this->render('update', [
                                    'model' => $model,
                        ]);
                    }
                } else {
                    return $this->render('update', [
                                'model' => $model,
                    ]);
                }
            }
        } else {
            throw new \yii\web\HttpException(403, 'El contenido no es suyo.');
        }
    }

    /**
     * Deletes an existing Noticia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionDelete($id) {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }
    public function actionDelete($id) {
        //BORRAR NOTICIA SOLO SI ERES EL CREADOR DE LA NOTICIA O ADMIN
        $Noticia = Noticia::findOne(['created_by' => Yii::$app->user->identity]);
        if (isset($Noticia) || Yii::$app->user->can('admin')) {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        } else {
            throw new \yii\web\HttpException(403, 'El contenido no es suyo.');

            die;
        }
    }

    /**
     * Finds the Noticia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Noticia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Noticia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
