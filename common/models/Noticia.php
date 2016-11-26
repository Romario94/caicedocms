<?php

namespace common\models;

use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\web\UploadedFile;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "noticia".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $seo_slug
 * @property string $detalle
 * @property integer $categoria_id
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property string $imagen
 *
 * @property Comentarios[] $comentarios
 * @property Categoria $categoria
 * @property User $createdBy
 * @property User $updatedBy
 */
class Noticia extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public $ImageFile;
    public $browselabel1 = 'Seleccionar imagen';
    public $browselabel2 = 'Actualizar imagen';
    
    public static function tableName() {
        return 'noticia';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['titulo', 'detalle', 'categoria_id'], 'required'],
            [['categoria_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['titulo', 'seo_slug'], 'string', 'max' => 100],
            [['imagen'], 'string', 'max' => 45],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'seo_slug' => 'Seo Slug',
            'detalle' => 'Detalle',
            'categoria_id' => 'Categoria ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'imagen' => 'Imagen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::className(), ['id_noticia' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
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
                'attribute' => 'titulo',
                'slugAttribute' => 'seo_slug',
            ],
        ];
}

    public function getAllLeft($slug) {

        $query = new \yii\db\Query();
        $query
                ->select(['noticia.*', 'noticia.id AS idNoticia', 'noticia.titulo AS tituloNoticia','noticia.seo_slug AS seoNoticia',
                    'noticia.detalle AS detalleNoticia','noticia.categoria_id AS categoriaNoticia','noticia.created_by AS createNoticia',
                    'noticia.created_at AS createdatNoticia','noticia.updated_by AS updateNoticia',
                    'noticia.updated_at AS updatedatNoticia'])
                ->from('noticia')
                ->where(['noticia.seo_slug' => $slug]); // COMENTARIOS APROBADOS TAMBIEN EN EL ARRAY


        $cmd = $query->createCommand();
        $posts = $cmd->queryAll();


        return $posts;
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
