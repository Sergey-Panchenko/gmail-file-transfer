<?php

namespace App\Services;

use App\Contracts\GoogleClientInterface;

class GDriveService extends \Google_Client implements GoogleClientInterface
{

    /**
     * GDriveService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setAuthConfig(base_path(self::CLIENT_SECRET_FILE_NAME));
        $this->setScopes([\Google_Service_Drive::DRIVE_FILE]);
        $this->setRedirectUri(route('drive-auth-callback'));
        $this->setToken();
    }

    /**
     * Save access token into session.
     *
     * @param array $accessToken
     */
    public function saveAccessToken($accessToken)
    {
        session()->put('drive-access-token', $accessToken);
    }

    /**
     * Set token from session and refresh if it expired.
     */
    public function setToken()
    {
        if (session()->has('drive-access-token')) {
            $accessToken = session()->get('drive-access-token');
            $this->setAccessToken($accessToken);
            if ($this->isAccessTokenExpired()) {
                $accessToken = $this->fetchAccessTokenWithRefreshToken($this->getRefreshToken());
                session()->put('drive-access-token', $accessToken);
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
     * Insert file in google disk.
     *
     * @param string $title
     *
     * @param string $mimeType
     *
     * @param string $data
     *
     * @param string $folderId
     *
     * @return \Google_Service_Drive_DriveFile
     */
    public function insertFile($title, $mimeType, $data, $folderId)
    {
        $file = new \Google_Service_Drive_DriveFile([
            'name' => $title,
        ]);
        if (!empty($folderId)) {
            $file->setParents([$folderId]);
        }
        $file->setMimeType($mimeType);
        $service = new \Google_Service_Drive($this);
        $createdFile = $service->files->create($file, [
            'data' => $data,
            'mimeType' => 'application/pdf',
        ]);

        return $createdFile;
    }

    /**
     * Create folder.
     *
     * @param string $name
     *
     * @return string
     */
    public function createFolder($name)
    {
        $folderData = new \Google_Service_Drive_DriveFile(
            [
                'name' => $name,
                'mimeType' => 'application/vnd.google-apps.folder'
            ]);

        $service = new \Google_Service_Drive($this);
        $folder = $service->files->create($folderData, ['fields' => 'id']);

        return $folder;
    }

}