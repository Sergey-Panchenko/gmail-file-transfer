<?php

namespace App\Managers;

class TransferFilesManager
{
    /**
     * Transfer files from gmail to google drive.
     *
     * @param string $query
     *
     * @param int $maxResults
     *
     * @param string $fileFormat
     *
     * @return array
     */
    public function transfer($query, $maxResults, $fileFormat) {
        $transferredFiles = [];
        $files = \GmailClient::getFiles($query, $maxResults, $fileFormat);
        //        2 уведомить пользователя
        if (!empty($files)) {
            $folder = \GDriveClient::createFolder('Files_' . time());
            foreach ($files as $file) {
                $transferredFiles[] = \GDriveClient::insertFile($file['fileName'], $file['mimeType'], $file['source'], $folder->id)->name;
            }
        }

        return $transferredFiles;
    }

}
