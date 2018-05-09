<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 23 Apr 2018 20:35:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Owner
 * 
 * @property int $id
 * @property string $Nombre
 * @property string $Faccion
 * @property int $Realm_id
 *
 * @package App\Models
 */
class Owner extends Eloquent {

    protected $table = 'owner';
    public $timestamps = false;
    protected $casts = [
        'Realm_id' => 'int'
    ];
    protected $fillable = [
        'Nombre',
        'Faccion',
        'Realm_id'
    ];

    public function scopeNombre($query, $nombre) {
        return $query->where('Nombre', '=', $nombre);
    }

}
