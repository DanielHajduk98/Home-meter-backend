<?php

namespace Tests\Feature;

use App\Models\Monitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class MonitorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_setup() {
        $macAddress = Monitor::factory()->make()->mac_address;

        // Check if api call works
        $response = $this->post("/api/monitor", ['mac_address' => $macAddress]);
        $response->assertStatus(200);

        // Check if token is String and 32 length
        $token = $response->getContent();
        self::assertIsString($token);
        self::assertEquals(strlen($token), 32);

        // Check if monitor was saved properly
        $monitor = Monitor::where("mac_address", "=", $macAddress)->first();
        self::assertNotEmpty($monitor);
        self::assertEquals($token, Crypt::decryptString($monitor->token));

        // Check if saved token returns proper message
        $response = $this->post("/api/monitor", ['mac_address' => $macAddress]);
        $response->assertStatus(200);
        self::assertEquals("Monitor already in DB", $response->getContent());
    }
}