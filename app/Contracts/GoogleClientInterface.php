<?php

namespace App\Contracts;

interface GoogleClientInterface
{
    const CLIENT_SECRET_FILE_NAME = 'client_secret.json';

    /**
     * Save access token.
     *
     * @param array $accessToken
     */
    public function saveAccessToken($accessToken);

    public function setToken();
}