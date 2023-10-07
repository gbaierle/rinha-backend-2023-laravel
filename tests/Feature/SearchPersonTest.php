<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchPersonTest extends TestCase
{
    use RefreshDatabase;

    private $data = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->data[] = Person::factory()->create([
            'nick' => 'josé',
            'name' => 'José Roberto',
            'birth_date' => '2000-10-01',
            'stack' => ['C#', 'Node', 'Oracle']
        ]);
        $this->data[] = Person::factory()->create([
            'nick' => 'ana',
            'name' => 'Ana Barbosa',
            'birth_date' => '1985-09-23',
            'stack' => ['Node', 'Postgres']
        ]);
    }

    public function testSearchPersonStack(): void
    {
        $response = $this->getJson('/pessoas?t=node');
        $response->assertSuccessful();
        $response->assertJsonCount(2, 'data');
        $response->assertJson([
            'data' => [
                [
                    'id' => $this->data[0]->uuid,
                    'apelido' => 'josé',
                    'nome' => 'José Roberto',
                    'nascimento' => '2000-10-01',
                    'stack' => ['C#', 'Node', 'Oracle']
                ], [
                    'id' => $this->data[1]->uuid,
                    'apelido' => 'ana',
                    'nome' => 'Ana Barbosa',
                    'nascimento' => '1985-09-23',
                    'stack' => ['Node', 'Postgres']
                ]
            ]
        ]);
    }

    public function testSearchPersonName(): void
    {
        $response = $this->getJson('/pessoas?t=roberto');
        $response->assertSuccessful();
        $response->assertJsonCount(1, 'data');
        $response->assertJson([
            'data' => [
                [
                    'id' => $this->data[0]->uuid,
                    'apelido' => 'josé',
                    'nome' => 'José Roberto',
                    'nascimento' => '2000-10-01',
                    'stack' => ['C#', 'Node', 'Oracle']
                ]
            ]
        ]);
    }

    public function testSearchWithoutMatch(): void
    {
        $response = $this->getJson('/pessoas?t=Python');
        $response->assertSuccessful();
        $response->assertJsonCount(0, 'data');
    }

    public function testWithoutSearchTermParam(): void
    {
        $response = $this->getJson('/pessoas');
        $response->assertBadRequest();
    }
}
