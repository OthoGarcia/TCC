<?php

namespace App\Http\Controllers\Role;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use Session;

class RolesController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\View\View
   */
   public function index(Request $request)
   {
      $keyword = $request->get('search');
      $perPage = 25;

      if (!empty($keyword)) {
         $roles = Role::where('nome', 'LIKE', "%$keyword%")
         ->orWhere('descricao', 'LIKE', "%$keyword%")

         ->paginate($perPage);
      } else {
         $roles = Role::paginate($perPage);
      }

      return view('admin.roles.index', compact('roles'));
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\View\View
   */
   public function create()
   {
      $permissions = \App\Permission::all();
      $users = \App\User::all();
      return view('admin.roles.create', compact('permissions','users'));
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
   public function store(Request $request)
   {

      $requestData = $request->all();

      $role = Role::create($requestData);
      $role->permissions()->sync($request->input('permissions'));
      $role_users = $request->input('users');
      foreach ($role_users as $id_users){
         $user = \App\User::findOrFail($id_users);
         $user->role()->associate($role);
         $user->save();
      }

      Session::flash('flash_message', 'Role added!');

      return redirect('role/roles');
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   *
   * @return \Illuminate\View\View
   */
   public function show($id)
   {
      $role = Role::findOrFail($id);

      return view('admin.roles.show', compact('role'));
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   *
   * @return \Illuminate\View\View
   */
   public function edit($id)
   {
      $role = Role::findOrFail($id);
      $permissions = \App\Permission::all();
      $users = \App\User::all();
      $role_permissions = $role->permissions();
      return view('admin.roles.edit', compact('role','permissions','role_permissions','users'));
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
   public function update($id, Request $request)
   {

      $requestData = $request->all();

      $role = Role::findOrFail($id);
      $role->update($requestData);
      $role->permissions()->sync($request->input('permissions'));
      $role_users = $request->input('users');
      $users = \App\User::all();
      foreach ($users as $user){
         if (in_array($user->id,$role_users)) {
            $user->role()->associate($role);
         }else {
            $user->role()->dissociate($role);
         }
         $user->save();
      }
      Session::flash('flash_message', 'Role updated!');

      return redirect('role/roles');
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
   public function destroy($id)
   {
      Role::destroy($id);

      Session::flash('flash_message', 'Role deleted!');

      return redirect('role/roles');
   }
}
