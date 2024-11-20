<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Module extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function access()
    {
        return $this->hasMany('App\Access', 'moduleID');
    }

    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'new_values.status')) {
            if($this->getOriginal('status')=="1"){
                $val = "Active";
            }else{
                $val = "Inactive";
            }

            if($this->getAttribute('status')=="1"){
                $val2 = "Active";
            }else{
                $val2 = "Inactive";
            }
            $data['old_values']['status'] = $val;
            $data['new_values']['status'] = $val2;
        }
        return $data;
    }
}
