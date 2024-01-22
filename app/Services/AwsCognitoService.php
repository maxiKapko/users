<?php

namespace App\Services;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Illuminate\Support\Facades\Log;

class AwsCognitoService
{
    protected $client;

    public function __construct()
    {
        $this->client = new CognitoIdentityProviderClient([
            'version' => 'latest',
            'region' => config('services.cognito.region'),
            'credentials' => [
                'key' => config('services.cognito.key'),
                'secret' => config('services.cognito.secret'),
            ],
        ]);
    }

    public function authenticate($username, $password)
    {
        try {
            $result = $this->client->adminInitiateAuth([
                'AuthFlow'       => 'ADMIN_NO_SRP_AUTH',
                'ClientId'       => config('services.cognito.client_id'),
                'UserPoolId'     => config('services.cognito.user_pool_id'),
                'AuthParameters' => [
                    'USERNAME' => $username,
                    'PASSWORD' => $password,
                ],
            ]);
            // Convert the AWS result to an array for logging
            $resultArray = $result->toArray();

            // Log the information
            Log::info('Cognito Authentication Result:', $resultArray);
            // Handle successful authentication, e.g., return user tokens
            return $result;
        } catch (\Exception $e) {
            // Handle authentication failure
            Log::error('Cognito Authentication Error:', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
