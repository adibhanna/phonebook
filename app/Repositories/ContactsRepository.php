<?php

namespace PhoneBook\Repositories;

use PhoneBook\Contact;

/**
 * Class ContactsRepository
 * @package PhoneBook\Repositories
 */
class ContactsRepository
{
    /**
     * @var Contact
     */
    protected $contact;

    /**
     * ContactsRepository constructor.
     * @param Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Search Contacts.
     * 
     * @param $user
     * @param $q
     * @return mixed
     */
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
