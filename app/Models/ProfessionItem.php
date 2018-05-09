<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 23 Apr 2018 20:35:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProfessionItem
 * 
 * @property int $Profession_id
 * @property int $item_id
 *
 * @package App\Models
 */
class ProfessionItem extends Eloquent
{
	protected $table = 'profession_item';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Profession_id' => 'int',
		'item_id' => 'int'
	];

	protected $fillable = [
		'Profession_id',
		'item_id'
	];
}
