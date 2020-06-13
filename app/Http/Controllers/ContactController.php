<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (auth()->user()->email != 'eslam.habsa94@gmail.com') {
            return response()->json([
                'message' => 'you have not permission to delete message'
            ], 403);
        }

        $contacts = Contact::all();
        $data = [];
        foreach ($contacts as $contact) {
            $data[] = [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'message' => $contact->message,
            ];
        }
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:30',
            'email' => 'required|email',
            'phone' => 'required|digits:11',
            'message' => 'required|min:10|max:500',
        ]);

        if ($contact = Contact::create($request->all())) {
            return response()->json([
                'message' => 'message is sent successfully',
                'contact' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                    'message' => $contact->message,
                ]
            ], 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Contact $contact
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Contact $contact)
    {
        if (auth()->user()->email != 'eslam.habsa94@gmail.com') {
            return response()->json([
                'message' => 'you have not permission to delete message'
            ], 403);
        }

        if($contact->delete()) {
            return response()->json([
                'message' => 'message is deleted successfully'
            ], 200);
        }
    }
}
