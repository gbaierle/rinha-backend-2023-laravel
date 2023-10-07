<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountPersonTest extends TestCase
{
    use RefreshDatabase;

    public function testCountPerson(): void
    {
        $data = Person::factory()->count(5)->create();

        $response = $this->getJson('/contagem-pessoas');
        $response->assertSuccessful();
        $response->assertSee(count($data));
    }
}
