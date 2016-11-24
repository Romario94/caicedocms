<?php

namespace backend\controllers;

use Yii;
use common\models\Categoria;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriaController implements the CRUD actions for Categoria model.
 */
class CategoriaController extends Controller
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
     * Lists all Categoria models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Categoria::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categoria model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Categoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   public function actionCreate()
    {
        $model = new Categoria();

        if ($model->load(Yii::$app->request->post()) ) {
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
     * Updates an existing Categoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
  public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        $oldFile = $model->getImageFile();

        $oldImage = $model->imagen;
        //$oldFileName = $model->nombre;


        if (!isset($oldFile) && !isset($oldImage)){
        if ($model->load(Yii::$app->request->post()) ) {

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


        if ($model->load(Yii::$app->request->post()) ) {

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

    }


    /**
     * Deletes an existing Categoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $Categoria= Categoria::findOne(['created_by' => Yii::$app->user->identity]);
        if (isset($Categoria) || Yii::$app->user->can('admin')) {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        } else {
            throw new \yii\web\HttpException(403, 'El contenido no es suyo.');

            die;
        }
    }

    /**
     * Finds the Categoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categoria::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
