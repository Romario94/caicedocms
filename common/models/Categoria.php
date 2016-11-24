<?php

namespace common\models;

use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\web\UploadedFile;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "categoria".
 *
 * @property integer $id
 * @property string $categoria
 * @property string $seo_slug
 * @property string $imagen
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property Noticia[] $noticias
 */
class Categoria extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    
    public $ImageFile;
    public $browselabel1 = 'Seleccionar imagen';
    public $browselabel2 = 'Actualizar imagen';
    
    public static function tableName() {
        return 'categoria';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['categoria'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['categoria', 'imagen'], 'string', 'max' => 200],
            [['seo_slug'], 'string', 'max' => 100],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'categoria' => 'Categoria',
            'seo_slug' => 'Seo Slug',
            'imagen' => 'Imagen',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticias() {
        return $this->hasMany(Noticia::className(), ['categoria_id' => 'id']);
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'categoria',
                'slugAttribute' => 'seo_slug',
            ],
        ];
    }
      public function getImageFile() {
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        return isset($this->imagen) ? Yii::$app->params['uploadPath'] . $this->imagen : null;
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl() {
        Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/web/uploads/';
        // return a default image placeholder if your source avatar is not found
        $imagen = isset($this->imagen) ? $this->imagen : 'default.jpg';
        return Yii::$app->params['uploadUrl'] . $imagen;
    }

    /**
     * Process upload of image
     *
     * @return mixed the uploaded image instance
     */
    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $imageFile = UploadedFile::getInstance($this, 'imagen');

        // if no image was uploaded abort the upload
        if (empty($imageFile)) {
            return false;
        }

        // store the source file name
        // $this->nombre = $imageFile->name;
        $ext = end((explode(".", $imageFile->name)));

        // generate a unique file name
        $this->imagen = Yii::$app->security->generateRandomString() . ".{$ext}";

        // the uploaded documento instance
        return $imageFile;
    }

    /**
     * Process deletion of image
     *
     * @return boolean the status of deletion
     */
    public function deleteImage() {
        $file = $this->getImageFile();

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }


        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }
        
        // }
        // if deletion successful, reset your file attributes
        $this->imagen = null;
        //$this->nombre = null;

        return true;
    }

    public function verifBrowseLabel() {
        return !isset($this->imagen) ? $this->browselabel1 : $this->browselabel2;
    }

}
