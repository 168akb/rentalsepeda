<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Level;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
       
        $users = User::when(request('search'), function($query){
                        return $query->where('name','like','%'.request('search').'%');
                    })
                    ->where('level_id', '=', 2)
                    ->orderBy('created_at','desc')
                    ->paginate(8);

        $data['totalAdmin'] = User::where('level_id', '=', 2)->count();

        return view('admin.index', compact('users', 'data'));
    }

    public function create(){
        $level = Level::all();
        return view('admin.create', compact('level'));
    }

    public function store(Request $request){        

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level_id = 2;
        $user->active = 0;
        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $message = 'Admin Berhasil ditambahkan';
        return redirect()->route('admins.index')->with('success',$message);
    } 

    public function edit($id){
        $level = Level::all();
        $user = User::find($id);
        return view('admin.edit', compact('user', 'level'));
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
        $user->active = $request->active;
        $user->level_id = 2;
        if(!empty($request->password)) {    
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $message = 'Admin Berhasil di update';
        return redirect()->route('admins.index')->with('success',$message);
        
    }

    public function destroy($id){

        $user = User::find($id);
        $user->delete();     

        return redirect()->route('admins.index')->with('success','User berhasil dihapus');                             
    }
}
