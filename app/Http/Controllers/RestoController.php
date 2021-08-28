<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Hash;

class RestoController extends Controller
{
    
    
//registerUser
    function registerUser(Request $req){
        $validateData = $req->validate([
        'name' => 'required|regex:/^[a-z A-Z]+$/u',
        'email' => 'required|email',
        'password' => 'required|min:6|max:12',
        'confirm_password' => 'required|same:password',
        ]);
        $result = DB::table('users')
        ->where('email',$req->input('email'))
        ->get();
        
        $res = json_decode($result,true);
        //print_r($res);
        
        if(sizeof($res)==0){
        $data = $req->input();
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $encrypted_password = Hash::make($data['password']);
        $user->password = $encrypted_password;
        $user->save();
        $req->session()->flash('register_status','User has been registered successfully');
        return redirect('/registration');
        }
        else{
        $req->session()->flash('register_status','This Email already exists.');
        return redirect('/registration');
        }
        }




        //Login Page

        // function login(Request $req){
        //     $validatedData = $req->validate([
        //     'email' => 'required|email',
        //     'password' => 'required'
        //     ]);
            
        //     $result = DB::table('users')
        //     ->where('email',$req->input('email'))
        //     ->get();
            
        //     $res = json_decode($result,true);
        //     //print_r($res);
            
        //     if(sizeof($res)==0){
        //     $req->session()->flash('error','Email Id does not exist. Please register yourself first');
        //     echo "Email Id Does not Exist.";
        //     return redirect('login');
        //     }
        //     else{
        //     echo "Hello";
        //     $encrypted_password = $result[0]->password;
        //     $data = user::where('password')->get();
        //     $new_password = Hash::make($req->input('password'));
        //     if($new_password==$encrypted_password){
        //     echo "You are logged in Successfully";
        //     $req->session()->put('user',$result[0]->name);
        //     return redirect('/');
        //     }
        //     else{
        //     $req->session()->flash('error','Password Incorrect!!!');
        //     echo "Email Id Does not Exist.";
        //     return redirect('login');
        //     }
        //     }
        //     }


            function login(Request $req)
            {
                $validatedData = $req->validate([
                        'email' => 'required|email',
                        'password' => 'required'
                        ]);
                $user = User::where(['email'=>$req->email])->first();
                if(!$user || !Hash::check($req->password, $user->password)){
                    return redirect('/login');
                }else{
                    $req->session()->put('user',$user);
                    return redirect('home');
                }   
            }

            function home()
            {
                return view('home');
            }
}
