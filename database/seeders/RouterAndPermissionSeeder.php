<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RouterAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        //Permission creation
        Permission::create(['name'=>'read']);
        Permission::create(['name'=>'create']);
        Permission::create(['name'=>'edit']);
        Permission::create(['name'=>'update']);
        Permission::create(['name'=>'delete']);
        Permission::create(['name'=>'trash']);
        Permission::create(['name'=>'publish']);
        Permission::create(['name'=>'unpublish']);
        Permission::create(['name'=>'sessions']); //Iniciar Session
        Permission::create(['name'=>'modify']); 
        Permission::create(['name'=>'special']); //Acciones Especiales como terminal en web, configuraciones avanzadas y mas..
        //Access Permission
        Permission::create(['name'=>'ap_sessions_admin']); // Acceso al Dashboard
        Permission::create(['name'=>'ap_post']);
        Permission::create(['name'=>'ap_post_cat']);
        Permission::create(['name'=>'ap_post_tag']);
        Permission::create(['name'=>'ap_page']);
        Permission::create(['name'=>'ap_comment_manager']);
        Permission::create(['name'=>'ap_subscription_manager']);
        Permission::create(['name'=>'ap_user_manager']);
        Permission::create(['name'=>'ap_config_manage']);

        //Role assignment
        //SUPER ADMIN
        $role = Role::create(['name' => 'SuperAdmin'])->givePermissionTo(Permission::all());

        //ADMIN
        $role = Role::create(['name' => 'Administrador'])->givePermissionTo([
        	//Access
        	'ap_sessions_admin','ap_post','ap_post_cat','ap_post_tag',
        	'ap_page', 'ap_comment_manager', 'ap_config_manage', 
        	'ap_subscription_manager','ap_user_manager',
        	//PERMISSION
        	'read','create','edit','update','delete','trash','publish','unpublish','sessions','modify',
        ]);
        
        //SPECIFIC ROLE
        $role = Role::create(['name' => 'Autor'])->givePermissionTo([
        	'ap_sessions_admin','ap_post','ap_post_cat','ap_post_tag','ap_comment_manager','ap_page','sessions', //Access
        	'modify','read','create','edit','update','trash','publish','unpublish'
        ]);
        $role = Role::create(['name' => 'Adminstrador de Suscripciones'])->givePermissionTo([
        	'ap_sessions_admin','ap_subscription_manager','sessions', //Access
        	'modify','read','create','edit','update','trash','publish','unpublish'
        ]);
        $role = Role::create(['name' => 'Suscriptor'])->givePermissionTo([
        	'read','sessions','ap_subscription_manager'
        ]);
        $role = Role::create(['name' => 'Comentarista'])->givePermissionTo([
        	'read','sessions','ap_comment_manager'
        ]);
    }
}
