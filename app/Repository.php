<?php


namespace App;


use App\Http\Requests\ValidationRequest;
use App\Models\Owner;

class Repository
{

    public function owner_data(ValidationRequest $request): array
    {
        return [
            'user_id' => auth()->user()->id,
            "owner" => $request->has('owner'),
        ];
    }


    public function property_data(array $validation): array
    {
        return [
            'house_name_number' => $validation['house_number'],
            'postcode' => $validation['postal_code'],
            'phones' => $validation['phones'],
            'address' => $validation['address'],
            'user_id' => auth()->user()->id,
            'owner_id' => Owner::get()->last()->id,
        ];
    }

    public function phone_data(array $validation, $type): array
    {
        return [
            'number' => $validation['phones'],
            'user_id' => auth()->user()->id,
            'phoneType' => $type,
        ];
    }

    public function data_table()
    {
        return redirect('/pages/show_homes');
    }


    public function validation(ValidationRequest $request): array
    {
        $validation = $request->validated();
        return $validation;
    }
}