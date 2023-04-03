<?php

namespace App\Http\Controllers\Admin\UserMessages;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;

class UserMessageController extends Controller
{
    public function index()
    {
        $messages = ContactUs::latest()->paginate(15);

        return view('admin.userMessages.index' , compact('messages'));
    }

    public function show(ContactUs $contactUs)
    {
        return view('admin.userMessages.show' , compact('contactUs'));
    }
}
