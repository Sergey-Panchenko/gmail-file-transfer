<?php

namespace App\Services;

use App\Contracts\GoogleClientInterface;

class GmailService extends \Google_Client implements GoogleClientInterface
{
    const USER_ME = 'me';

    /**
     * GmailService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setAuthConfig(base_path(self::CLIENT_SECRET_FILE_NAME));
        $this->setScopes([\Google_Service_Gmail::GMAIL_READONLY]);
        $this->setRedirectUri(route('gmail-auth-callback'));
        $this->setToken();
    }

    /**
     * Save access token into session.
     *
     * @param array $accessToken
     */
    public function saveAccessToken($accessToken)
    {
        session()->put('gmail-access-token', $accessToken);
    }

    /**
     * Set token from session and refresh if it expired.
     */
    public function setToken()
    {
        if (session()->has('gmail-access-token')) {
            $accessToken = session()->get('gmail-access-token');
            $this->setAccessToken($accessToken);
            if ($this->isAccessTokenExpired()) {
                $accessToken = $this->fetchAccessTokenWithRefreshToken($this->getRefreshToken());
                session()->put('gmail-access-token', $accessToken);
            }
        }
    }

    /**
     * Get auth url.
     *
     * @return string
     */
    public function getAuthUrl()
    {
        return $this->createAuthUrl();
    }

    /**
     * Get files from gmail account.
     *
     * @param string $query
     *
     * @param int $maxResults
     *
     * @param string $fileFormat
     *
     * @return array
     */
    public function getFiles($query, $maxResults, $fileFormat)
    {
        $files = [];
        $service = new \Google_Service_Gmail($this);
        $results = $service->users_messages->listUsersMessages(self::USER_ME,
            [
                'maxResults' => $maxResults,
                'q' => $query
            ]);
        foreach ($results as $result) {
            $message = $service->users_messages->get(self::USER_ME, $result->id);
            foreach ($message->payload->parts as $part) {
                if ($part->mimeType = $fileFormat) {
                    if (!empty($part->body->attachmentId)) {
                        $attachment = $service->users_messages_attachments->get(self::USER_ME, $result->id, $part->body->attachmentId);
                        $files[] = [
                          'fileName' => $part->filename,
                          'mimeType' => $part->mimeType,
                          'source' => base64_decode(str_replace(array('-', '_'), array('+', '/'), $attachment->data)),
                        ];
                    }
                }
            }
        }

        return $files;
    }
}