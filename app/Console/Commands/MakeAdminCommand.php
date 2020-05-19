<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Console\Command;
use App\User;
use App\PasswordReset;
use Illuminate\Support\Str;
use App\Notifications\UserPasswordResetNotification;
use Spatie\Permission\Models\Role;

class MakeAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For creating a website admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = [];
        $data['name'] = $this->ask('What is your name?');
        $data['email'] = $this->ask('What is your email?');

        if($this->validator($data)->fails()){
            $this->error('Data not valid');
            return;
        }
        $password = Str::random(40);
        $user=User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($password),
        ]);
        
        $this->sendPasswordResetLink($user);

        $role = Role::findByName("admin");
        $user->assignRole($role->name);
        echo "User created !!!\n\n";
    }

    private function sendPasswordResetLink(User $user){
        $user->passwordResets()->delete();
        do{
            $code = Str::random(225);          
        }while(PasswordReset::where('token',$code)->count()>0);
        $passwordReset = new PasswordReset;
        $passwordReset->token = $code;
        $passwordReset->user_id = $user->id;
        $passwordReset->save();
        $user->notify(new UserPasswordResetNotification());
    }
}
