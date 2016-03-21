<?php

namespace PhoneBook\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use PhoneBook\Http\Controllers\Controller;
use PhoneBook\Http\Requests\ContactRequest;

/**
 * Class ContactsController
 * @package PhoneBook\Http\Controllers\Api
 */
class ContactsController extends Controller
{
    /**
     * The authenticated user.
     *
     * @var User
     */
    protected $authUser;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->authUser = Auth::user();
    }

    /**
     * List the contacts.
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function listing()
    {
        return $this->authUser->contacts()->paginate(10);
    }

    /**
     * Search contact.
     * 
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $search = $request->get('q');

        if($search){
            return $this->authUser->searchContacts($search);
        }
    }

    /**
     * Store a new contact.
     *
     * @param ContactRequest $request
     *
     * @return mixed
     */
    public function store(ContactRequest $request)
    {
        return $this->authUser->contacts()->create($request->all());
    }

    /**
     * Update the contact.
     *
     * @param $id
     * @param ContactRequest $request
     * @return mixed
     */
    public function update($id, ContactRequest $request)
    {
        $contact = $this->authUser->contacts()->findOrFail($id);

        $contact->update($request->all());

        return $contact;
    }

    /**
     * Delete a contact.
     *
     * @param $id
     *
     * @return json
     */
    public function delete($id)
    {
        $contact = $this->authUser->contacts()->findOrFail($id);

        if ($contact->delete()) {
            return response('Successfully deleted the contact', 200);
        }

        return response('Could not delete the contact.', 401);

    }
}
