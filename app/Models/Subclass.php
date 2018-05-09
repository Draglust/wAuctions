<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 23 Apr 2018 20:35:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Subclass
 * 
 * @property int $Id
 * @property string $Nombre
 *
 * @package App\Models
 */
class Subclass extends Eloquent
{
	protected $table = 'subclass';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nombre'
	];
}
