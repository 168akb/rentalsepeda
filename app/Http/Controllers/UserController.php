<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Level;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
       
        $users = User::when(request('search'), function($query){
                        return $query->where('name','like','%'.request('search').'%');
                    })
                    ->where('level_id', '=', 1)
                    ->orderBy('created_at','desc')
                    ->paginate(8);

        $data['totalUser'] = User::where('level_id', '=', 1)->count();

        return view('user.index', compact('users', 'data'));
    }

    public function create(){
        $level = Level::all();
        return view('user.create', compact('level'));
    }

    public function store(Request $request){        

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level_id = 1;
        $user->active = 0;
        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $message = 'Owner Berhasil ditambahkan';
        return redirect()->route('users.index')->with('success',$message);
    } 

    public function edit($id){
        $level = Level::all();
        $user = User::find($id);
        return view('user.edit', compact('user', 'level'));
    }

     public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::findOrFail($id);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->level_id = 1;
        if(!empty($request->password)) {    
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $message = 'Owner Berhasil di update';
        return redirect()->route('users.index')->with('success',$message);
        
    }

    public function destroy($id){

        $user = User::find($id);
        $user->delete();     

        return redirect()->route('users.index')->with('success','User berhasil dihapus');                             
    }
}
