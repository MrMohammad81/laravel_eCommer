<?php

namespace App\Http\Controllers\Admin\UserMessages;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use function view;

class UserMessageController extends Controller
{
    public function index()
    {
        $messages = ContactUs::latest()->paginate(15);

        return view('admin.users.userMessages.index' , compact('messages'));
    }

    public function show(int $id)
    {
        $contactUs = ContactUs::findOrFail($id);

        return view('admin.users.userMessages.show' , compact('contactUs'));
    }
}
