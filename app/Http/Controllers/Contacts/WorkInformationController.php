<?php

namespace App\Http\Controllers\Contacts;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Contact\Contact;
use App\Http\Controllers\Controller;
use App\Services\Contact\Contact\UpdateWorkInformation;
use App\Services\Contact\Description\SetPersonalDescription;
use App\Services\Contact\Description\ClearPersonalDescription;
use App\ViewHelpers\ContactHelper;

class WorkInformationController extends Controller
{
    /**
     * Add work information to the given contact.
     *
     * @param Contact $contact
     * @return Response
     */
    public function create(Request $request, Contact $contact)
    {
        $request = [
            'account_id' => auth()->user()->account_id,
            'author_id' => auth()->user()->id,
            'contact_id' => $contact->id,
            'job' => $request->input('title'),
            'company' => $request->input('companyName'),
        ];

        $contact = (new UpdateWorkInformation)->execute($request);

        return response()->json([
            'data' => [
                'title' => $contact->job,
                'company' => $contact->company,
                'description' => ContactHelper::getWorkInformation($contact),
            ],
        ], 200);
    }
}
