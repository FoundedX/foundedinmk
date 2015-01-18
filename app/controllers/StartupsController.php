<?php

use G6\FoundedInMk\Entities\Startup;

class StartupsController extends BaseController
{
    public function index()
    {
        $startups = Startup::all();

        return View::make('admin.startups.index', compact('startups'));
    }

    public function delete($id)
    {
        $data = [
            "status" => "warning",
            "message" => "There was some error with your request"
        ];

        if (Startup::destroy($id)) {
            $data["status"] = "success";
            $data["message"] = "The startup was successfully deleted.";
        }

        return Response::json($data);
    }

    public function toggleFeatured($id)
    {
        $startup = Startup::find($id);

        if (!$startup) {
            $data = [
                "status" => "warning",
                "message" => "There was some error with your request"
            ];

            return Response::json($data);
        }

        $startup->featured = !$startup->featured;
        $startup->save();

        $data = [
            "status" => "success",
            "message" => "The startup was successfully changed."
        ];

        return Response::json($data);
    }

    public function approve($id)
    {
        $startup = Startup::find($id);

        if (!$startup) {
            $data = [
                "status" => "warning",
                "message" => "There was some error with your request"
            ];

            return Response::json($data);
        }

        $startup->approved = true;
        $startup->save();

        $data = [
            "status" => "success",
            "message" => "The startup was successfully approved."
        ];

        if ($startup->contact_email != "") {
            Mail::send('emails.startup-approved', ["startup" => $startup],
                function($message) use ($startup) {
                    $message->to($startup->contact_email)->subject('Startup application approved');
                }
            );
        }

        return Response::json($data);
    }

    public function decline($id)
    {
        $startup = Startup::find($id);

        if (!$startup) {
            $data = [
                "status" => "warning",
                "message" => "There was some error with your request"
            ];

            return Response::json($data);
        }

        $startup->delete();

        $data = [
            "status" => "success",
            "message" => "The startup was successfully declined."
        ];

        if ($startup->contact_email != "") {
            Mail::send('emails.startup-declined', ["startup" => $startup],
                function($message) use ($startup) {
                    $message->to($startup->contact_email)->subject('Startup application declined');
                }
            );
        }

        return Response::json($data);
    }

    public function edit($id)
    {
        $startup = Startup::find($id);

        return View::make('admin.startups.edit', compact('startup'));
    }

    public function update($id)
    {
        $startup = Startup::find($id);
        $startup->fill(Input::all());

        if (Input::hasFile('logo')) {
            $logo = Input::file('logo');
            $startupNameHash = md5($startup->name);
            $fileName =  md5($logo->getClientOriginalName()) . "." . $logo->getClientOriginalExtension();
            $logo->move(public_path() . "/static/logos/" . $startupNameHash, $fileName);
            $startup->logo = $startupNameHash . "/". $fileName;
        }


        $startup->save();

        return Redirect::route('admin.startups.index');

    }
} 