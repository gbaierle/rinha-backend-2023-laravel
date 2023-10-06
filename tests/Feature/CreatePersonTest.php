<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreatePersonTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testPostShouldCreatePerson(): void
    {
        $data = [
            'apelido' => $this->faker->unique()->userName(),
            'nome' => $this->faker->word(),
            'nascimento' => $this->faker->date('Y-m-d'),
            'stack' => [
                $this->faker->word(),
                $this->faker->word(),
            ],
        ];

        $response = $this->postJson('/pessoas', $data);

        $response->assertCreated();
        $response->assertJson(['data' => $data]);
        $response->assertHeader('Location', sprintf('/pessoas/' . $response->json()['data']['uuid']));
    }

    public function testDuplicateNickShouldBeInvalid(): void
    {
        $data = [
            'apelido' => $this->faker->unique()->userName(),
            'nome' => $this->faker->word(),
            'nascimento' => $this->faker->date('Y-m-d'),
            'stack' => [
                $this->faker->word(),
                $this->faker->word(),
            ],
        ];

        Person::factory()->create([
            'nick' => $data['apelido'],
        ]);


        $response = $this->postJson('/pessoas', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testNullNickShouldBeInvalid(): void
    {
        $data = [
            'nome' => $this->faker->word(),
            'nascimento' => $this->faker->date('Y-m-d'),
            'stack' => [
                $this->faker->word(),
            ],
        ];

        $response = $this->postJson('/pessoas', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testNullNameShouldBeInvalid(): void
    {
        $data = [
            'apelido' => $this->faker->unique()->userName(),
            'nascimento' => $this->faker->date('Y-m-d'),
            'stack' => [
                $this->faker->word(),
            ],
        ];

        $response = $this->postJson('/pessoas', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testNonStringNameShouldBeInvalid(): void
    {
        $data = [
            'apelido' => $this->faker->unique()->userName(),
            'nome' => 123,
            'nascimento' => $this->faker->date('Y-m-d'),
            'stack' => [
                $this->faker->word(),
            ],
        ];

        $response = $this->postJson('/pessoas', $data);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testNonStringStackShouldBeInvalid(): void
    {
        $data = [
            'apelido' => $this->faker->unique()->userName(),
            'nome' => $this->faker->word(),
            'nascimento' => $this->faker->date('Y-m-d'),
            'stack' => [1, 'PHP'],
        ];

        $response = $this->postJson('/pessoas', $data);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
