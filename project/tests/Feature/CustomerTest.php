<?php

namespace Tests\Feature;

use App\Services\DataImporterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->customers = (new DataImporterService)->import();
    }

    #[Test]
    public function validate_customer_collection_structure(): void
    {
        $response = $this->json(
            'GET',
            route('customers.index')
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'full_name',
                        'email',
                        'country'
                    ]
                ]
            ]);
    }


    #[Test]
    public function validate_customer_resource_structure(): void
    {
        $response = $this->json(
            'GET',
            route('customers.show', ['customer' => 1])
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'full_name',
                    'email',
                    'username',
                    'gender',
                    'country',
                    'city',
                    'phone'
                ]
            ]);
    }

    #[Test]
    public function invalid_customer_should_return_404(): void
    {
        $response = $this->json(
            'GET',
            route('customers.show', ['customer' => 9999])
        );

        $response
            ->assertStatus(404);
    }

    #[Test]
    public function request_must_not_sent_to_3rd_party_api()
    {
        Http::fake(function (Request $request) {
            if ($request->url() === config('data_importer.api_data_url')) {
                return Http::response('', 404);
            }
            return Http::response('', 200);
        });

        Http::assertNotSent(config('data_importer.api_data_url'));

        $response = $this->json(
            'GET',
            route('customers.index')
        );

        $response->assertStatus(200);
    }
}
