<?php

namespace PhoneBook\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Input;
use PhoneBook\User;
use PhoneBook\Http\Requests;
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
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->authUser = Auth::user();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = Input::get('q');

        if(!is_null($search)) {
            $contacts = $this->authUser->contacts()
                ->where('name', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%")
                ->orWhere('notes', 'LIKE', "%$search%")
                ->orWhere('updated_at', 'LIKE', "%$search%")
                ->paginate(10);
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
