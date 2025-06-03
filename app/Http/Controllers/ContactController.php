<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::where('user_id', Auth()->id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%");
            });
        }

        $contacts = $query->paginate(10)->withQueryString();
        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function import(Request $request)
    {
        if ($request->hasFile('xml_file')) {
            $xml = simplexml_load_file($request->file('xml_file')->getRealPath());
            $count = 0;

            foreach ($xml->contact as $contact) {
                Contact::create([
                    'name' => (string) $contact->name,
                    'phone' => (string) $contact->phone,
                    'user_id' => Auth::id(),
                ]);
                $count++;
            }

            return response()->json(['status' => 'success', 'imported' => $count]);
        }

        return response()->json(['status' => 'error', 'message' => 'No XML file provided.'], 400);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
        ]);

        $data['user_id'] = Auth::id();  // associate contact with current user

        Contact::create($data);

        return redirect()->route('contacts.index')->with('success', 'Contact saved!');
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50'
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($request->only(['name', 'phone']));

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');
    }


    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted!');
    }
}
