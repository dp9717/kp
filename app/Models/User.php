<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'original_password',
        'mobile',
        'office_no',
        'office_email',
        'pan_file',
        'aadhar_file',
        'designation',
        'additional_information',
        'slug',
        'status',
        'resume_file',
        'other_file'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'original_password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function userPluck($value='')
    {
        return User::where('is_admin',1)->pluck('name','slug');
    }

    public static function userData($value='')
    {
        $user = User::where('is_admin',1);
        if ($value) {
            $user->where('id',$value);
        }
        return $user->first();
    }

    public static function password($value='')
    {
        return 12345678;//rand(10000000,99999999);
    }

    public function userRole($value='')
    {
        return $this->hasOne('\App\Models\UserRole','user_id','id')->select('id','user_id','role_id');
    }
    public function userAddress($value='')
    {
        return $this->hasOne('\App\Models\UserAddress','user_id','id');
    }

    public static function status($value='')
    {
        $data =[1=>'Active',2=>'Inactive'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function userAry($value='')
    {
        return User::where('id',$value)->select('id', 'name', 'email', 'mobile', 'office_no', 'office_email', 'designation', 'additional_information', 'slug', 'qualification', 'profession')->first();
    }

    public static function id($value='')
    {
        return User::where(['status'=>1,'slug'=>$value])->first()->id;
    }

    public static function slug($value='')
    {
        return User::where(['status'=>1,'id'=>$value])->first()->slug;
    }

    public static function qualification ($value=null)
    {
        $data = [  1 => 'Homeschooling', 2 => '10th Pass',3 =>'12th Pass',4 =>'Undergraduate',5 =>'Postgraduate',6=>'Diploma',7=>'Phd Doctorate',8=>'Other'];
        if ($value) {
            return $data[$value];
        }else{
            $dt = $data;
            return $dt;
        }
    }

    public static function profession ($value=null)
    {
        $data = [  1 => 'Entrepreneur', 2 => 'Politician',3 =>'Social Activist',4 =>'Bureaucrat',5 =>'Lawyer',6=>'Doctor',7=>'Industrialist',8=>'Teacher',9=>'Teacher',10=>'Principal',11=>'Accountant',12=>'IT Engineer',13=>'IT consultant',14=>'Architect',15=>'Software Developer',16=>'Designer',17=>'Farmer',18=>'Journalist',19=>'Judge',20=>'Financial Consultant',21=>'Banker',22=>'Government Service',23=>'Other',24=>'Volunteer',25=>'Trustee',26=>'MD',27=>'CEO',28=>'Director',29=>'Project Manager',30=>'HOD',31=>'Other'];
        if ($value) {
            return $data[$value];
        }else{
            $dt = $data;
            return $dt;
        }
    }
}


