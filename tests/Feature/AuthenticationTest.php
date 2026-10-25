<?php
namespace Tests\Feature; use Tests\TestCase; use Illuminate\Foundation\Testing\RefreshDatabase; use App\Models\User; use Illuminate\Support\Facades\Hash;
class AuthenticationTest extends TestCase { use RefreshDatabase; public function test_login_page_is_available():void{$this->get('/login')->assertOk();} public function test_user_can_log_in():void{$u=User::factory()->create(['password'=>Hash::make('password'),'active'=>true]);$this->post('/login',['email'=>$u->email,'password'=>'password'])->assertRedirect('/dashboard');} }
