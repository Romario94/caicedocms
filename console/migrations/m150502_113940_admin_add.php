<?php

use yii\db\Schema;
use yii\db\Migration;
use common\models\User;

class m150502_113940_admin_add extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'admin',
            'email' => 'webmaster@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('admin'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            //'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            //'status' => User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time()
        ]);
        $this->insert('{{%user}}', [
            'id' => 2,
            'username' => 'manager',
            'email' => 'manager@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('manager'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            //'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            //'status'=> User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time()
        ]);
        $this->insert('{{%user}}', [
            'id' => 3,
            'username' => 'user',
            'email' => 'user@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('user'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            //'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            //'status' => User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time()
        ]);
    }
    
    public function safeDown()
    {
        /**@var $admin common\models\User*/
        $admin = \common\models\User::findByEmail('admin@example.ru');
        if($admin){
            $admin->delete();
            echo "El administrador ha sido eliminado con éxito";
        }else{
            echo "Administrador no existe";
        }
        return true;
    }
}
