<?php

namespace App\Http\Controllers\Api;

use App\Role;
use Illuminate\Http\Request;

class RoleControlle extends Controller
{
    public function  roles() {
        $roles = Role::all();

        return response(['status' => true, 'roles' => $roles]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $role = new Role();
        $role->name = $request->name;

        if ($role->save()) return response(['message' => 'Register Success!', 'status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::where('name', $request->name)->first();
        if ($role) return response(['message' => 'Updated Successfully!', 'status' => true]);
        return response(['message' => 'Update Failed', 'status' => false]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
