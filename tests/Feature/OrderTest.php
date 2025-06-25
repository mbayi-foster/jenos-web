<?php

namespace Tests\Feature;

use App\Models\Commande;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $code = Commande::generateSimpleCode();

        // Exemple : ORDER-24-06-25-XXXXXX
        $this->assertMatchesRegularExpression('/^ORDER-24-06-25-\d{6}$/', $code);
    }

   
}
