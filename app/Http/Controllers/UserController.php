<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    const BASE_URL = 'localhost/rest-server/public';
    const URL_TARGET = 'http://' . self::BASE_URL . '/api/dev';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Http::get(self::URL_TARGET, [
            'key' => 'AU3t3wWxeR7pJgUKQZFH'
        ]);
        $models = json_decode($response, true)['data'];
        return view('user.index', ['models' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        User::validateData($request);
        $create = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);
        if ($create) {
            return redirect('/')->with('success', 'Data created successfully!');
        }else{
            return redirect('/')->with('danger', 'Data failed to generate!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $model = User::findOrFail($user->id);
        return view('user.show', ['model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $model = User::findOrFail($user->id);
        return view('user.edit', ['model' => $model]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $model = User::findOrFail($user->id);
        User::validateData($request);
        
        if ($model->email !== $request->email) {
            $count = User::where('email', 'like', '%' . $request->email . '%')->count();
            if ($count > 0) {
                return redirect('edit/'.$model->id)->with('error', $request->email . ' has already been taken.');
            }
        }
        
        $update = $model->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        if ($update) {
            return redirect('/')->with('success', 'Data was updated successfully!');
        }else{
            return redirect('/')->with('danger', 'Data failed to update!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $model = User::findOrFail($user->id);
        $delete = $model->delete();
        if ($delete) {
            return redirect('/')->with('success', 'Data deleted successfully!');
        }else{
            return redirect('/')->with('danger', 'Data failed to delete!');
        }
    }
}
