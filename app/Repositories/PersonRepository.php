<?php

namespace App\Repositories;

use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class PersonRepository
{
    public function count(): int
    {
        return Person::count();
    }

    public function getById(string $uuid): Person
    {
        return Person::where('uuid', $uuid)->firstOrFail();
    }

    public function search(string $searchTerm): Collection
    {
        return Person::query()
            ->where('nick', 'LIKE', "%$searchTerm%")
            ->orWhere('name', 'LIKE', "%$searchTerm%")
            ->orWhere('stack', 'LIKE', "%$searchTerm%")
            ->limit(50)
            ->get();
    }

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
