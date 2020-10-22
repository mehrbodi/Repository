<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidationRequest;
use App\Models\Property;
use App\Models\Phone;
use App\Models\Owner;
use App\Repository;

class MyController extends Controller
{
    /**
     * first page of the web
     */
    public function index()
    {
        return view('layouts/app');
    }

    /**
     * Show the form for creating a  new resource.
     */
    public function create()
    {
        return view('layouts.add_home');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(ValidationRequest $request, Repository $obj)
    {
        Owner::create($obj->owner_data($request));
        $validation = $obj->validation($request);
        Property::create($obj->property_data($validation));
        $type = $request->types;
        Phone::create($obj->phone_data($validation, $type));
        return $obj->data_table();
    }

    /**
     * Display the specified resource.
     *
     */
    public function show()
    {
        $test = Property::all();
        return view('layouts.show_home',compact('test'));
    }

    /**
     * Show the form for editing resource.
     *
     */
    public function edit(Property $post_id)
    {
        $phone = phone::find($post_id->id);
        $prop = Property::find($post_id->id)->owner()->get()->pluck('owner');
        $owner = $prop[0];

        $posts = Property::find($post_id);

        return view('layouts.single_page',compact('posts','owner','phone'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(ValidationRequest $request, Property $home, Repository $obj)
    {

        $post_data = Property::find($home->id);
        $post_owner= Owner::find($home->id);
        $post_num = Phone::find($home->id);
        $type = $request->types;

        $validation = $obj->validation($request);

        $post_owner->update($obj->owner_data($request));
        $post_data->update($obj->property_data($validation));
        $post_num->update($obj->phone_data($validation, $type));


        return $obj->data_table();
    }

    /**
     * Delete the specified resource in storage.
     *
     */
    public function destroy(Property $del, Repository $obj)
    {
        $del->delete();
        return $obj->data_table();
    }




}