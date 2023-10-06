<?php

namespace App\Repositories;

use App\Models\Person;
use Carbon\Carbon;

class PersonRepository
{
    public function store(array $data): Person
    {
        $person = new Person();
        $person->uuid = uuid_create();
        $person->name = $data['nome'];
        $person->nick = $data['apelido'];
        $person->birth_date = Carbon::createFromFormat('Y-m-d', $data['nascimento']);
        $person->stack = $data['stack'];
        $person->save();
        return $person;
    }
}
