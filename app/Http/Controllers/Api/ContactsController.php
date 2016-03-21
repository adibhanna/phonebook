<?php

namespace PhoneBook\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use PhoneBook\Http\Controllers\Controller;
use PhoneBook\Http\Requests\ContactRequest;

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

    public function listing()
    {
        return $this->authUser->contacts()->latest()->paginate(10);
    }

    public function store(Request $request)
    {
        return $request->get('data');
        return $this->authUser->contacts()->create($request->all());
    }
}
