<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 23 Apr 2018 20:35:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Auction
 * 
 * @property int $Id
 * @property int $Apuesta
 * @property int $Compra
 * @property int $Cantidad
 * @property string $Tiempo_restante
 * @property int $Json_id
 * @property int $Owner_id
 * @property int $Realm_id
 * @property int $Item_id
 *
 * @package App\Models
 */
class Auction extends Eloquent
{
	protected $table = 'auction';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'Apuesta' => 'int',
		'Compra' => 'int',
		'Cantidad' => 'int',
		'Json_id' => 'int',
		'Owner_id' => 'int',
		'Realm_id' => 'int',
		'Item_id' => 'int'
	];

	protected $fillable = [
		'Apuesta',
		'Compra',
		'Cantidad',
		'Tiempo_restante',
		'Json_id',
		'Owner_id',
		'Realm_id',
		'Item_id'
	];
}
