<?php

use G6\FoundedInMk\Entities\Startup;

class PublicController extends BaseController
{
	public function index()
	{
        $featured = Startup::where('approved', true)->where('featured', true)->orderBy('name')->get()->all();

        $startups = Startup::where('approved', true)->where('featured', false)->orderBy('name')->get()->all();

		return View::make('homepage', compact('startups', 'featured'));
	}

    public function create()
    {
        $input = Input::all();

        $validator = Validator::make($input,
            [
                'name' => 'required',
                'year_founded' => 'required|digits:4',
                'website' => 'required|url',
                'twitter' => 'required|alpha_dash',
                'logo_url' => 'required|url',
                'contact_name' => 'alpha',
                'contact_email' => 'email'
            ]
        );

        if ($validator->fails()) {
            $data['status'] = 'warning';
            //$data['message'] = "Please enter valid information";
            $data['message'] = $validator->messages()->first();

            return Response::json($data);
        }

        $input['founded'] = $input['year_founded'];
        $input['url'] = $input['website'];

        $startup = Startup::create($input);

        if (Input::has('contact_email')) {
            $email = $input['contact_email'];
            Mail::send('emails.startup-submitted', [],
                function($message) use ($email) {
                    //$message->from('no-reply@mydomain.com', 'My Domain Sender');
                    $message->to($email)->subject('Startup successfully submitted');
                }
            );
        }

        $data['status'] = 'success';
        $data['message'] = "Startup submitted and waiting to be approved.";

        return Response::json($data);
    }
}

