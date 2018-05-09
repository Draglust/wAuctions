<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 23 Apr 2018 20:35:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Json
 * 
 * @property int $Id
 * @property string $Url
 * @property \Carbon\Carbon $Fecha
 * @property int $Fecha_numerica
 *
 * @package App\Models
 */
class Json extends Eloquent {

    protected $table = 'json';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $casts = [
        'Fecha_numerica' => 'int'
    ];
    protected $dates = [
        'Fecha'
    ];
    protected $fillable = [
        'Url',
        'Fecha',
        'Fecha_numerica'
    ];

    public function scopeFecha_numerica($query, $date) {
        return $query->where('Fecha_numerica', '=', $date);
    }

    public function scopeFecha($query, $date) {
        return $query->where('Fecha', '=', $date);
    }

}
