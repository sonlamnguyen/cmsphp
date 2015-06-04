<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Hash;
use App\Helpers\ResTools as ResTools;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function editPassword($id, $oldPassword, $newPassword){
        $item = User::find($id);
        if($item){
            if(!Hash::check($oldPassword, $item->password)){
                return ResTools::resErr(['password' => 'Wrong old password']);
            }
            $password = Hash::make($newPassword);
            $item->password = $password;
            $item->save();
            $result = [
                'id' => $item->id,
                'name' => $item->name
            ];
            return ResTools::resObj($result, 'Change password success.');
        }
        return ResTools::resErr('User not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    }

    public static function obj($id){
        if($id === null){
            return ResTools::resErr('Invalid ID');
        }
        $item = User::find($id);
        if($item){
            return ResTools::resObj($item);
        }
        return ResTools::resErr('Item not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    }

    public static function objs(){
        $items = User::paginate(ResTools::PER_PAGE);
        return ResTools::resObj($items);
    }

    public static function allObjs(){
        $items = User::all();
        return ResTools::resObj($items);
    }

    public static function add($data){
        $item = new User;
        $existUser = User::where('email', '=', $data['email'])->first();
        if($existUser){
            return ResTools::resErr(['email' => 'Email address had been used! Please choose another one']);
        }
        $data['password'] = Hash::make($data['password']);
        $item->fill($data);
        $item->save();
        $result = [
            'id' => $item->id,
            'name' => $item->name,
            'email' => $item->email,
            'role' => $item->role,
        ];
        return ResTools::resObj($result, 'Create new user success');
    }

    public static function edit($id, $data){
        $item = User::find($id);
        if($item){
            $existUser = User::where('email', '=', $data['email'])->first();
            if($existUser && $existUser->id != $id){
                return ResTools::resErr(['email' => 'Email address had been used! Please choose another one']);
            }
            $password = $data['password'];
            if(!$password){
                unset($data['password']);
            }
            $item->update($data);
            if($password){
                $item->password = Hash::make($password);
                $item->save();
            }
            $result = [
                'id' => $item->id,
                'name' => $item->name,
                'email' => $item->email,
                'role' => $item->role,
            ];
            return ResTools::resObj($result, 'Update user success');
        }
        return ResTools::resErr('User not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    }

    public static function editProfile($id, $data){
        $item = User::find($id);
        if($item){
            $item->update($data);
            $result = [
                'id' => $item->id,
                'name' => $item->name
            ];
            return ResTools::resObj($result, 'Update profile success');
        }
        return ResTools::resErr('User not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    }

    public static function remove($id){
        $item = User::find($id);
        if($item){
            $result = [
                'id' => $item->id,
            ];
            $item->forceDelete();
            return ResTools::resObj($result, 'Remove user success');
        }
        return ResTools::resErr('User not exist', ResTools::$ERROR_CODES['NOT_FOUND']);
    }
}
