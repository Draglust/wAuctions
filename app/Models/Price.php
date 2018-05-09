<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 23 Apr 2018 20:35:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Price
 * 
 * @property int $Id
 * @property int $Precio_medio
 * @property int $Precio_minimo
 * @property int $Precio_maximo
 * @property string $Faccion
 * @property int $Item_id
 * @property \Carbon\Carbon $Fecha
 * @property int $Total_objetos
 *
 * @package App\Models
 */
class Price extends Eloquent
{
	protected $table = 'price';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'Precio_medio' => 'int',
		'Precio_minimo' => 'int',
		'Precio_maximo' => 'int',
		'Item_id' => 'int',
		'Total_objetos' => 'int'
	];

	protected $dates = [
		'Fecha'
	];

	protected $fillable = [
		'Precio_medio',
		'Precio_minimo',
		'Precio_maximo',
		'Faccion',
		'Item_id',
		'Fecha',
		'Total_objetos'
	];
}
