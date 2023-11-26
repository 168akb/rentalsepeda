<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Level;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(){
        $members = User::when(request('search'), function($query){
                        return $query->where('name','like','%'.request('search').'%');
                    })
                    ->where('level_id', '3')
                    ->orderBy('created_at','desc')
                    ->paginate(8);

        $data['totalMem'] = User::where('level_id', 3)->count();

        return view('member.index', compact('members', 'data'));
    }

    public function create(){
        $level = Level::all();
        return view('member.create', compact('level'));
    }

    public function edit($id){
        $level = Level::all();
        $user = User::find($id);
        return view('member.edit', compact('user', 'level'));
    }

     public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::findOrFail($id);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->active = $request->active;
        if(!empty($request->password)) {    
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $message = 'Member Berhasil di update';
        return redirect()->route('members.index')->with('success',$message);
        
    }

    public function store(Request $request){        

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level_id = 3;
        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $message = 'Member Berhasil ditambahkan';
        return redirect()->route('members.index')->with('success',$message);
    } 

    public function destroy($id){

        $user = User::find($id);
        $user->delete();     

        return redirect()->route('members.index')->with('success','Member berhasil dihapus');                             
    }

    
}
