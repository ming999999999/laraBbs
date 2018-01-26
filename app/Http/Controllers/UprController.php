<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UprController extends Controller
{
    public function index(User $user,Role $role,Permission $permission)
    {

    	// 新建角色
		// $role  = Role::create(['name'=>'nihao']);

		// // 为角色添加权限
		// Permission::create(['name'=>'manage_visitor']);
 
		// $role->givePermissionTo('manage_visitor');

		// // 赋予用户某个角色
		// // 单个角色
		// $user->assignRole('Founder');

		// // 多个角色
		// $user->assignRole('writer','admin');

		// // 数组的形式的多个角色
		// $user->assignRole(['writer','admin']);



		// 检测方法
		// $data = $user->hasRole('Founder');

		
		// // var_dump($data);die;

		// $role = Role::find(1);

		// // 检查角色是否拥有某个权限
		// $data = $role->hasPermissionTo('manage_contents');
		

		// 获取所有直接权限q
		// $user = User::find(1);
		// $data = $user->getDirectPermissions();
		// dd($data);


		return view('upr.index');
    }

}
