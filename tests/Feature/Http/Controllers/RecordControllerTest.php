<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class RecordControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testExample(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
