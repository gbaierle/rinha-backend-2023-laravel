<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePersonRequest;
use App\Http\Resources\PersonResource;
use App\Repositories\PersonRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PersonController extends Controller
{
    private PersonRepository $repository;

    public function __construct(PersonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function count()
    {
        $count = $this->repository->count();
        return response($count);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('t');

        if (!$searchTerm) {
            abort(Response::HTTP_BAD_REQUEST);
        }

        $persons = $this->repository->search($searchTerm);
        return PersonResource::collection($persons);
    }

    public function show(Request $request, string $uuid)
    {
        $person = $this->repository->getById($uuid);
        return new PersonResource($person);
    }

    public function store(CreatePersonRequest $request)
    {
        $person = $this->repository->store($request->validated());
        $response = (new PersonResource($person))->toResponse($request);
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->header('Location', "/pessoas/{$person->uuid}");
        return $response;
    }
}
