<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 23 Apr 2018 20:35:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ClassSubclass
 * 
 * @property int $Class_id
 * @property int $Subclass_id
 * @property int $Id
 *
 * @package App\Models
 */
class ClassSubclass extends Eloquent
{
	protected $table = 'class_subclass';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Class_id' => 'int',
		'Subclass_id' => 'int',
		'Id' => 'int'
	];

	protected $fillable = [
		'Class_id',
		'Subclass_id'
	];

    public function scopeClase_Subclase($query,$clase,$subclase) {
        return $query->where('Clase_id','=',$clase)->where('Subclase_id','=',$subclase);
    }
}
