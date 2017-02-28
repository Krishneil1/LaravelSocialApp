<?php

namespace Chatty\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

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
    protected $fillable = [
        'username', 
        'email', 
        'password',
        'first_name',
        'last_name',
        'location',
        ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token'];
    public function getName()/* Gets Name*/
    {
        if($this->first_name && $this->last_name)
        {
            return "{$this->first_name} {$this->last_name}";
        }
        if($this->first_name)
        {
            return $this->first_name;
        }
        return null;
    }
    public function getNameOrUsername()
    {
        return $this->getName() ? : $this->username;
    }
    public function getFirstNameOrUsername()
    {
        return $this->first_name ? : $this->username;/*Gets First or Last Name*/
    }

    public function getAvatarUrl()
    {
        return "https://www.gravatar.com/avatar/{{ md5($this->email) }}?d=mm&s=40";/*Sets the avatat of peope*/
    }
    public function friendsOfMine()
    {
        return $this->belongsToMany('Chatty\Models\User','friends','user_id','friend_id');//friend is pivot table
    }
    public function friendOf()
    {
        return $this->belongsToMany('Chatty\Models\User','friends','friend_id','user_id');//friend is pivot table
    }
    public function friends()
    {
        return $this->friendsOfMine()
                    ->wherePivot('accepted',true)
                    ->get()//collection
                    ->merge($this->friendOf()//This is done to create two way relationship Alex friends with Dale and Dale friends with Alex even though Alex add Dale as a Friend
                    ->wherePivot('accepted','true')->get());
    }
}
