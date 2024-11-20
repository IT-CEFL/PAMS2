<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Currency extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'currencies';

    public function application() {
        return $this->hasMany('App\Application');
    }

    public function priceRange() {
        return $this->hasMany('App\PriceRange');
    }
    
}
