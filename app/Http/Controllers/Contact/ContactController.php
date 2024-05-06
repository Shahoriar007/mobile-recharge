<?php

namespace App\Http\Controllers\Contact;

use App\Models\Contact;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'nullable|email',
                'company' => 'nullable|string',
                'subject' => 'nullable|string',
                'message' => 'nullable|string',
            ]);

            $ip = $request->ip();
            $response = Http::get("http://ip-api.com/json/$ip?fields=country");
            $country = $response->json()['country'] ?? null;

            $contact = new Contact();
            $contact->name = $request->name;
            $contact->phone = $request->phone;
            $contact->email = $request->email;
            $contact->company = $request->company;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->country = $country;
            $contact->save();

            $cc = explode(',', config('mail.contact-cc'));

            if ($country == 'Bangladesh') {
                Mail::to(env('CONTACT_EMAIL_BD'))->cc($cc)->send(new ContactMail($contact, $ip));
            }else{
                Mail::to(env('CONTACT_EMAIL'))->cc($cc)->send(new ContactMail($contact, $ip));
            }

            return response()->json(['message' => 'Contact created successfully'], 201);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }


    }

    public function index()
    {
        $breadcrumbs = [
            ['link' => "/contacts", 'name' => "Contacts"], ['name' => "Index"]
        ];

        $data = Contact::latest('created_at')->paginate(10);
        return view('contacts.index', compact('data', 'breadcrumbs'));
    }
}
