<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    // Control url api service
    const BASE_URL = 'localhost/rest-server/public';
    const URL_TARGET = 'http://' . self::BASE_URL . '/api/dev';
    const KEY = 'AU3t3wWxeR7pJgUKQZFH';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Http::get(self::URL_TARGET, [
            'key' => self::KEY
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
        $response = Http::get(self::URL_TARGET, [
            'key' => self::KEY
        ]);
        $result = json_decode($response, true)['data'];
        
        $create = Http::asForm()->post(self::URL_TARGET, [
            'key' => self::KEY,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        for ($i = 0; $i < count($result); $i++) {
            if ($request->email === $result[$i]['email']) {
                $result = json_decode($create, true);
                return redirect('create')->with('danger', $result['message']);
            }
        }

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
    public function show(Request $request)
    {
        $response = Http::get(self::URL_TARGET, [
            'key' => self::KEY,
            'id' => $request->id
        ]);
        $model = json_decode($response, true)['data'];
        return view('user.show', ['model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $response = Http::get(self::URL_TARGET, [
            'key' => self::KEY,
            'id' => $request->id
        ]);
        $model = json_decode($response, true)['data'];

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
        $response = Http::get(self::URL_TARGET, [
            'key' => self::KEY
        ]);
        $result = json_decode($response, true)['data'];
        
        $update = Http::asForm()->put(self::URL_TARGET, [
            'key' => self::KEY,
            'id' => $request->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        $index = 0;
        for ($i = 0; $i < count($result); $i++) {
            if ($request->id == $result[$i]['id']) {
                $index = $i;
            }
        }

        if ($request->email !== $result[$index]['email']) {
            for ($i = 0; $i < count($result); $i++) {
                if ($request->email === $result[$i]['email']) {
                    $result = json_decode($update, true);
                    return redirect('edit?id='.$request->id)->with('danger', $result['message']);
                }
            }
        }

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
    public function destroy(Request $request)
    {
        $delete = Http::asForm()->delete(self::URL_TARGET, [
            'key' => self::KEY,
            'id' => $request->id
        ]);

        if ($delete) {
            return redirect('/')->with('success', 'Data deleted successfully!');
        }else{
            return redirect('/')->with('danger', 'Data failed to delete!');
        }
    }
}
