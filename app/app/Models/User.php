<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const COMMON_NAME = 'user';

    const STATUS_INIT = 0;
    const STATUS_NORMAL = 1000;
    const STATUS_DELETE = 4004;

    const TYPE_INIT = 0;
    const TYPE_NORMAL = 1;
    const TYPE_TEST = 5;
    const TYPE_VIP = 9;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * User constructor.
     * @param int $status
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {

//        parent::__construct($attributes);
        //此方法调用之后，所有属性都被赋值了
        if (count($attributes) > 0) {

            $this->initWithAttributes($attributes);

        }

        return $this;

    }

    /**
     *
     * array $attributes
     *
     * @param $attributes
     */
    public function initWithAttributes($attributes){

        $this->guid = guid();
//        $this->account = User::getMaxAccountNo() + 1;
        isset($attributes['email']) && $this->email = $attributes['email'];
        isset($attributes['mobile']) && $this->mobile = $attributes['mobile'];
        $this->name = $attributes['name'];

        isset($attributes['type']) && $this->type = $attributes['type'];
        isset($attributes['password']) && $this->password = encodeHashedPassword($attributes['password']);


//        isset($attributes['true_name']) && $this->school = $attributes['true_name'];
//        isset($attributes['title']) && $this->school = $attributes['title'];
//        isset($attributes['school']) && $this->school = $attributes['school'];
//        isset($attributes['company']) && $this->company = $attributes['company'];
//        isset($attributes['language']) && $this->language = $attributes['language'];
//        isset($attributes['country']) && $this->country = $attributes['country'];
//        isset($attributes['province']) && $this->province = $attributes['province'];
//        isset($attributes['city']) && $this->city = $attributes['city'];
//        isset($attributes['district']) && $this->district = $attributes['district'];
//        isset($attributes['address']) && $this->address = $attributes['address'];
//        isset($attributes['gender']) && $this->gender = $attributes['gender'];
//        isset($attributes['identify']) && $this->identify = $attributes['identify'];
//        isset($attributes['birthday']) && $this->birthday = $attributes['birthday'];

        if(!$this->save()){
            return null;
        }
        return $this;

    }





}
