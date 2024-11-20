<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Department extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'departments';

    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'new_values.Status')) {
            if($this->getOriginal('Status')=="1"){
                $val = "Active";
            }else{
                $val = "Inactive";
            }

            if($this->getAttribute('Status')=="1"){
                $val2 = "Active";
            }else{
                $val2 = "Inactive";
            }
            $data['old_values']['Status'] = $val;
            $data['new_values']['Status'] = $val2;
        }
        return $data;
    }

}
