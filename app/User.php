<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Arr;

class User extends Authenticatable implements Auditable
{
    protected $table = 'user';

    use Notifiable;
    use \OwenIt\Auditing\Auditable;

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

    public function dept() {
        return $this->belongsTo('App\Department', 'deptID');
    }
    public function role() {
        return $this->belongsTo('App\Role', 'roleID');
    }
    public function centre() {
        return $this->belongsTo('App\Centre', 'centreID');
    }
    public function application() {
        return $this->hasMany('App\Application');
    }
    public function approvalFlow() {
        return $this->hasMany('App\ApprovalFlow');
    }
    public function previousApp()
    {
        return $this->hasMany('App\Application', 'previousApp');
    }

    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'new_values.roleID')) {
            if($this->getOriginal('roleID')!= NULL){
                $data['old_values']['roleID'] = Role::find($this->getOriginal('roleID'))->RoleName;
            }

            $data['new_values']['roleID'] = Role::find($this->getAttribute('roleID'))->RoleName;
        }

        if (Arr::has($data, 'new_values.Status')) {
            if($this->getOriginal('Status')!= NULL){
                if($this->getOriginal('Status')=="1"){
                    $val = "Active";
                }else{
                    $val = "Inactive";
                }
                $data['old_values']['Status'] = $val;
            }
            if($this->getAttribute('Status')=="1"){
                $val2 = "Active";
            }else{
                $val2 = "Inactive";
            }
                $data['new_values']['Status'] = $val2;
        }

        if (Arr::has($data, 'new_values.deptID')) {
            if($this->getOriginal('deptID')!= NULL){
                $data['old_values']['deptID'] = Department::find($this->getOriginal('deptID'))->DeptName;
            }

            $data['new_values']['deptID'] = Department::find($this->getAttribute('deptID'))->DeptName;
        }

        if (Arr::has($data, 'new_values.centreID')) {
            if($this->getOriginal('centreID')!= NULL){
                $data['old_values']['centreID'] = Centre::find($this->getOriginal('centreID'))->CentreName;
            }

            $data['new_values']['centreID'] = Centre::find($this->getAttribute('centreID'))->CentreName;
        }

        if (Arr::has($data, 'new_values.password')) {

            if($this->getOriginal('password')!= NULL){
                if($this->getOriginal('password') == $this->getAttribute('password')){
                    $val = "Password didnt change";
                }else{
                    $val = "Password have change";
                }
                $data['old_values']['password'] = $val;
            }

            if($this->getAttribute('password')){
                $val2 = "Encrypted password have been set";
                $data['new_values']['password'] = $val2;
            }

        }

        return $data;
    }
    
}
