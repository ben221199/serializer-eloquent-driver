<?php
namespace NilPortugues\Tests\Serializer\Drivers\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
	/**
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * @var string
	 */
	protected $table = 'orders';

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user(){
		return $this->belongsTo(User::class, 'user_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function likes(){
		return $this->morphMany(Like::class, 'likeable');
	}

}