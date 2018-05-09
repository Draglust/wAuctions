<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 23 Apr 2018 20:35:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Item
 * 
 * @property int $Id
 * @property string $Nombre
 * @property string $Descripcion
 * @property string $Icono
 * @property int $Calidad
 * @property int $Nivel_objeto
 * @property int $Nive_requerido
 * @property string $Expansion
 * @property int $Class_Subclass_Id
 * @property string $Tipo_inventario
 *
 * @package App\Models
 */
class Item extends Eloquent
{
	protected $table = 'item';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'Calidad' => 'int',
		'Nivel_objeto' => 'int',
		'Nive_requerido' => 'int',
		'Class_Subclass_Id' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Descripcion',
		'Icono',
		'Calidad',
		'Nivel_objeto',
		'Nive_requerido',
		'Expansion',
		'Class_Subclass_Id',
		'Tipo_inventario'
	];

    public function scopeNombreIsNull($query) {
        return $query->whereNull('Nombre');
    }

    public function scopeId($query,$id) {
        return $query->where('Id','=',$id);
    }

    public function scopeItem_Fecha_Faccion($query, $item, $fecha, $faccion) {
        return $query->where('Item_id', '=', $item)->where('Fecha', '=', $fecha)->where('Faccion', '=', $faccion);
    }
}
