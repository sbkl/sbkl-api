<?php

namespace sbkl\SbklApi\Tests\Feature;

use Carbon\CarbonImmutable;
use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use Illuminate\Database\Eloquent\Factory;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser;
use sbkl\SbklApi\Models\Company;
use sbkl\SbklApi\Models\User;
use sbkl\SbklApi\Tests\LaravelTestCase;

class AuthTest extends LaravelTestCase
{
    /** @test */
    public function a_user_can_login_with_laravel_passport()
    {
        $this->withoutExceptionHandling();

        $company = Company::create([
            'name' => 'Burberry',
        ]);

        $user = User::create([
            'company_id' => $company->id,
            'first_name' => 'Sebastien',
            'last_name' => 'Koziel',
            'email' => 'sebastien.koziel@burberry.com',
            'lang' => 'en',
            'password' => \Hash::make($password = 'secret'),
        ]);

        $client = $this->app->make(Factory::class)->of(Client::class)->state('password_client')->create(['user_id' => $user->id]);

        $response = $this->post(
            '/oauth/token',
            [
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $user->email,
                'password' => $password,
            ]
        );
        $response->assertOk();
        $response->assertHeader('pragma', 'no-cache');
        $response->assertHeader('cache-control', 'no-store, private');
        $response->assertHeader('content-type', 'application/json; charset=UTF-8');

        $decodedResponse = $response->decodeResponseJson();

        $this->assertArrayHasKey('token_type', $decodedResponse);
        $this->assertArrayHasKey('expires_in', $decodedResponse);
        $this->assertArrayHasKey('access_token', $decodedResponse);
        $this->assertArrayHasKey('refresh_token', $decodedResponse);
        $this->assertSame('Bearer', $decodedResponse['token_type']);
        $expiresInSeconds = 31536000;
        $this->assertEqualsWithDelta($expiresInSeconds, $decodedResponse['expires_in'], 5);

        $jwtAccessToken = (new Parser())->parse($decodedResponse['access_token']);
        $this->assertTrue($this->app->make(ClientRepository::class)->findActive($jwtAccessToken->getClaim('aud'))->is($client));
        $this->assertTrue($this->app->make('auth')->createUserProvider()->retrieveById($jwtAccessToken->getClaim('sub'))->is($user));

        $token = $this->app->make(TokenRepository::class)->find($jwtAccessToken->getClaim('jti'));
        $this->assertInstanceOf(Token::class, $token);
        $this->assertFalse($token->revoked);
        $this->assertTrue($token->user->is($user));
        $this->assertTrue($token->client->is($client));
        $this->assertNull($token->name);
        $this->assertLessThanOrEqual(5, CarbonImmutable::now()->addSeconds($expiresInSeconds)->diffInSeconds($token->expires_at));
    }

    /** @test */
    public function a_user_can_retrieve_its_profile_information()
    {
        $this->withExceptionHandling();
        [
            'admin_user' => $admin_user,
        ] = EntityFactory::create();

        $response = $this->jsonAs($admin_user, 'GET', 'api/user')->decodeResponseJson();

        $this->assertEquals([
            'data' => [
                'id' => 4,
                'first_name' => $admin_user->first_name,
                'last_name' => $admin_user->last_name,
                'email' => $admin_user->email,
                'lang' => $admin_user->lang,
                'password_changed' => (bool) $admin_user->password_changed_at,
                'plant_id' => $admin_user->plant_id,
                'plant_name' => $admin_user->plant->name,
                'market' => $admin_user->plant->market->name,
                'region' => $admin_user->plant->market->region->name,
                'role' => $admin_user->roles()->first()->name,
            ],
        ], $response);
    }
}
