<?php

namespace Tests\Feature\Models;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class categoryTest extends TestCase
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
