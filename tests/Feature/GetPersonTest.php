<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetPersonTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testGetPersonById(): void
    {
        $person = Person::factory()->create();

        $response = $this->getJson("/pessoas/{$person['uuid']}");

        $response->assertSuccessful();
        $response->assertJson([
            'data' => [
                'id' => $person['uuid'],
                'apelido' => $person['nick'],
                'nome' => $person['name'],
                'nascimento' => $person['birth_date']->format('Y-m-d'),
                'stack' => $person['stack'],
            ]
        ]);
    }

    public function testGetNonExistingPerson(): void
    {
        $response = $this->getJson("/pessoas/123");
        $response->assertNotFound();
    }
}
