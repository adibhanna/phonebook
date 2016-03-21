<?php

namespace PhoneBook\Http\Controllers;

/**
 * Class PagesController
 * @package PhoneBook\Http\Controllers
 */
class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the SPA app.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('spa.app');
    }
}
