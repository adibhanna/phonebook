<?php

namespace PhoneBook;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package PhoneBook
 */
class User extends Authenticatable
{
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * A user might have many contacts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Search user contact.
     *
     * @param $q
     * @return mixed
     */
    public function searchContacts($q)
    {
        return $this->contacts()
            ->where('name', 'LIKE', "%$q%")
            ->orWhere('phone', 'LIKE', "%$q%")
            ->orWhere('notes', 'LIKE', "%$q%")
            ->orWhere('updated_at', 'LIKE', "%$q%")
            ->paginate(10);
    }
}
