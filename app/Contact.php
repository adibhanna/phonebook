<?php

namespace PhoneBook;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 * @package PhoneBook
 */
class Contact extends Model
{
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'phone', 'notes'];

    /**
     * A contact belongs to a user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
