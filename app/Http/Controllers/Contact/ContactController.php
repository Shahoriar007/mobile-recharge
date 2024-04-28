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

            info($request->all());

            $ip = $request->ip();

            info($ip);

            $response = Http::get("http://ip-api.com/json/$ip?fields=country");

            info($response->json());
            $country = $response->json()['country'] ?? null;

            info($country);

            $contact = new Contact();
            $contact->name = $request->name;
            $contact->phone = $request->phone;
            $contact->email = $request->email;
            $contact->company = $request->company;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->country = $country;
            $contact->save();

            if ($country == 'Bangladesh') {
                Mail::to(env('CONTACT_EMAIL_BD'))->send(new ContactMail($contact));
            }else{
                Mail::to(env('CONTACT_EMAIL'))->send(new ContactMail($contact));
            }

            return response()->json(['message' => 'Contact created successfully'], 201);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'There was an error processing your request'], 500);
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
