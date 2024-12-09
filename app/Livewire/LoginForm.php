<?php

namespace App\Livewire;

use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use LdapRecord\Container;
use Livewire\Component;

class LoginForm extends Component
{
    public $user;
    public $username;
    public $password;

    public function render()
    {
        return view('livewire.login-form');
    }

    public function login(){
        $user = Users::where('Name', 'MOH\jardel.regis')->first();
        Auth::login($user);
        redirect()->route('/');
        // $connection = Container::getConnection('default'); //Gets LDAP connection
        // $username = "MOH\\" . $this->username;  //Adding the MOH domain to username

        // $this->user = Users::where('Name', $username)->first();
        // if($this->user){
        //     $ADuser = $connection->query()->where('samaccountname', '=', $this->username)->first(); //Gets user from AD
            
        //     if ($connection->auth()->attempt($ADuser['distinguishedname'][0], $this->password)){ //Authenticates user credentials
        //         Auth::login($this->user);
        //         redirect()->route('/');
        //     }else{
        //         $this->addError('password', 'Incorrect Password');
        //     }
        // }else{
        //     $this->resetValidation();
        //     $this->addError('username', 'User does not have access to this system');
        //     $this->addError('error', 'User does not have access to this system');
        // }
    }
}
