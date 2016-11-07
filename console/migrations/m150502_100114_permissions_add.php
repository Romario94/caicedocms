<?php

use yii\db\Schema;
use yii\db\Migration;

class m150502_100114_permissions_add extends Migration
{
    private $permissions = [
        'r_main'=>'Ver la página de inicio de administración',
        'w_main'=>'Edición de la página de inicio de administración',
        'backend'=>'El acceso al panel de administración',
    ];
    private $permissionsAdmin = [
        'r_user'=>'Buscando miembros',
        'w_user'=>'Cambiar usuario',
        'r_role'=>'Ver los roles y derechos',
        'w_role'=>'Cambio de funciones y derechos',
    ];

    public function safeUp()
    {
        //add roles and permissions
        $roleModer = Yii::$app->authManager->createRole('moderator');
        $roleModer->description = 'Moderador';
        Yii::$app->authManager->add($roleModer);


        $roleAdmin = Yii::$app->authManager->createRole('admin');
        $roleAdmin->description = 'Admin';
        Yii::$app->authManager->add($roleAdmin);


        foreach($this->permissions as $name=>$desc){
            $perm = Yii::$app->authManager->createPermission($name);
            $perm->description = $desc;
            Yii::$app->authManager->add($perm);
            Yii::$app->authManager->addChild($roleAdmin, $perm);

            Yii::$app->authManager->addChild($roleModer, $perm);

        }
        foreach($this->permissionsAdmin as $name=>$desc){
            $perm = Yii::$app->authManager->createPermission($name);
            $perm->description = $desc;
            Yii::$app->authManager->add($perm);
            Yii::$app->authManager->addChild($roleAdmin, $perm);
        }

    }

    public function safeDown()
    {
        foreach($this->permissions as $name=>$desc){
            $perm = Yii::$app->authManager->getPermission($name);
            if ($perm)
                Yii::$app->authManager->remove($perm);
        }

        foreach($this->permissionsAdmin as $name=>$desc){
            $perm = Yii::$app->authManager->getPermission($name);
            if ($perm)
                Yii::$app->authManager->remove($perm);
        }

        echo "derecho a eliminar";

        $role = Yii::$app->authManager->getRole('admin');
        if ($role) {
            Yii::$app->authManager->removeChildren($role);
            Yii::$app->authManager->remove($role);
        }

        $role = Yii::$app->authManager->getRole('moderator');
        if ($role) {
            Yii::$app->authManager->removeChildren($role);
            Yii::$app->authManager->remove($role);
        }

    }
}

