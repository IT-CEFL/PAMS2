<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use OwenIt\Auditing\Contracts\Auditable;

class Centre extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'centres';

    public function user()
    {
        return $this->hasMany('App\User');
    }
    
    public function approvalFlow()
    {
        return $this->hasMany('App\ApprovalFlow');
    }

    public function transformAudit(array $data): array
    {
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
        return $data;
    }

}
