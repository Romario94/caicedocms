<?php

namespace common\models;

use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\web\UploadedFile;
use yii\db\Expression;
use Yii;


/**
 * This is the model class for table "comentarios".
 *
 * @property integer $id
 * @property string $comentario
 * @property integer $id_usuario
 * @property integer $id_noticia
 * @property string $estado
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $idUsuario
 * @property Noticia $idNoticia
 */
class Comentarios extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'comentarios';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['comentario'], 'required'],
            [['id_usuario', 'id_noticia'], 'integer'],
            [['estado'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['comentario'], 'string', 'max' => 255],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_usuario' => 'id']],
            [['id_noticia'], 'exist', 'skipOnError' => true, 'targetClass' => Noticia::className(), 'targetAttribute' => ['id_noticia' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'comentario' => 'Comentario',
            'id_usuario' => 'Id Usuario',
            'id_noticia' => 'Id Noticia',
            'estado' => 'Estado',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario() {
        return $this->hasOne(User::className(), ['id' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdNoticia() {
        return $this->hasOne(Noticia::className(), ['id' => 'id_noticia']);
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
           
        ];
    }

}
