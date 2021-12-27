<?php

namespace Tests\Feature\Auth;

use App\Models\Cadastros\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered()
    {
        $user = Usuario::factory()->create();

        $response = $this->actingAs($user)->get('/confirmar-senha');

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed()
    {
        $user = Usuario::factory()->create();

        $response = $this->actingAs($user)->post('/confirmar-senha', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password()
    {
        $user = Usuario::factory()->create();

        $response = $this->actingAs($user)->post('/confirmar-senha', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
