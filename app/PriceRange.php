<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PriceRange extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function approvalFlow() {
        return $this->hasMany('App\ApprovalFlow');
    }

    public function curren() {
        return $this->belongsTo('App\Currencies', 'ccy');
    }

    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'new_values.ccy')) {
            if($this->getOriginal('ccy')!= NULL){
                $data['old_values']['ccy'] = Currencies::find($this->getOriginal('ccy'))->currencyName;
            }

            $data['new_values']['ccy'] = Currencies::find($this->getAttribute('ccy'))->currencyName;
        }
        return $data;
    }
}
