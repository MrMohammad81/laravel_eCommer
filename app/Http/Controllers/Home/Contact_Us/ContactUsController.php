<?php

namespace App\Http\Controllers\Home\Contact_Us;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Requests\Home\ContactUsForm\ContactUsFormRequest;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('home.contact-us.index');
    }

    public function contactUsForm(ContactUsFormRequest $request)
    {
        $request->validated();

        $this->sendUserMessage($request);

        alert()->success('ارسال پیام','پیام شما با موفقیت ارسال شد و در اسرع وقت به شما پاسخ داده خواهد شد.با تشکر از شکیبایی شما')->showConfirmButton('تایید');
        return redirect()->route('home.index');
    }

    private function sendUserMessage($request)
    {
        ContactUs::create([
            'name' => $request->name,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
            'subject' => $request->subject,
            'text' => $request->text,
        ]);
    }
}
