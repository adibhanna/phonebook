<?php

namespace PhoneBook\Http\Controllers;

use Auth;
use PhoneBook\Contact;
use PhoneBook\Repositories\ContactsRepository;
use PhoneBook\User;
use PhoneBook\Http\Requests;
use Illuminate\Support\Facades\Input;
use PhoneBook\Http\Requests\ContactRequest;

/**
 * Class HomeController
 * @package PhoneBook\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * The authenticated user.
     *
     * @var User
     */
    protected $authUser;

    /**
     * @var ContactsRepository
     */
    protected $contactsRepository;

    /**
     * Create a new controller instance.
     * @param ContactsRepository $contactsRepository
     */
    public function __construct(ContactsRepository $contactsRepository)
    {
        $this->middleware('auth');

        $this->authUser = Auth::user();
        $this->contactsRepository = $contactsRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = Input::get('q');

        if(!is_null($search) && $search != ''){
            $contacts = $this->authUser->searchContacts($search);
        } else {
            $contacts = $this->authUser->contacts()->latest()->paginate(10);
        }

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Store a new contact.
     *
     * @param ContactRequest $request
     * @return mixed
     */
    public function store(ContactRequest $request)
    {
        $this->authUser->contacts()->create($request->all());

        return redirect()->to('/')->with(['success' => 'Successfully added a new contact.']);
    }

    /**
     * Show the edit page for a contact.
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $contact = $this->authUser->contacts()->findOrFail($id);

        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the contact.
     *
     * @param ContactRequest $request
     * @return mixed
     */
    public function update(ContactRequest $request)
    {
        $contact = $this->authUser->contacts()->findOrFail($request->id);

        $contact->update($request->all());

        return redirect()->to('/');
    }

    /**
     * Delete a contact.
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $contact = $this->authUser->contacts()->findOrFail($id);

        $contact->delete();

        return redirect()->to('/')->with(['success' => 'Successfully deleted the contact.']);
    }
}
