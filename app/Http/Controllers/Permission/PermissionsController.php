<?php

namespace App\Http\Controllers\Permission;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Permission;
use Illuminate\Http\Request;
use Session;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

     public function __construct()
     {
         $this->middleware('auth');
     }
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $permissions = Permission::where('nome', 'LIKE', "%$keyword%")
				->orWhere('descricao', 'LIKE', "%$keyword%")

                ->paginate($perPage);
        } else {
            $permissions = Permission::paginate($perPage);
        }

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.permissions.create');
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
      $this->validate($request, [
         'nome' => 'required|max:255',
         'descricao' => 'required',
      ]);
        $requestData = $request->all();

        Permission::create($requestData);

        Session::flash('flash_message', 'Permission added!');

        return redirect('permission/permissions');
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
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.show', compact('permission'));
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
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.edit', compact('permission'));
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
      $this->validate($request, [
         'nome' => 'required|max:255',
         'descricao' => 'required',
      ]);

        $requestData = $request->all();

        $permission = Permission::findOrFail($id);
        $permission->update($requestData);

        Session::flash('flash_message', 'Permission updated!');

        return redirect('permission/permissions');
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
        Permission::destroy($id);

        Session::flash('flash_message', 'Permission deleted!');

        return redirect('permission/permissions');
    }
}
