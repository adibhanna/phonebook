<?php

namespace PhoneBook\Repositories;

use Illuminate\Support\Facades\DB;
use PhoneBook\Contact;

class ContactsRepository
{
    /**
     * @var Contact
     */
    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function search($user, $q)
    {
        return $user->contacts()
            ->where('user_id', $user->id)
            ->orWhere('name', 'LIKE', '%$q%')
            ->orWhere('phone', 'LIKE', '%$q%')
            ->orWhere('notes', 'LIKE', '%$q%')
            ->orWhere('updated_at', 'LIKE', '%$q%')
            ->paginate(10);
    }
}
