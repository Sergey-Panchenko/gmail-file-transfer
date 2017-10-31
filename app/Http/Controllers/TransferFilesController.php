<?php

namespace App\Http\Controllers;

use App\Managers\TransferFilesManager;

class TransferFilesController extends Controller
{
    /**
     * Show home page with links to authorize users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $gmailAuth = [
            'url' => \GmailClient::getAuthUrl(),
            'authorized' => session()->has('gmail-access-token')
        ];
        $driveAuth = [
            'url' => \GDriveClient::getAuthUrl(),
            'authorized' => session()->has('drive-access-token')
        ];

        return view('welcome', compact('gmailAuth', 'driveAuth'));
    }

    /**
     * @param TransferFilesManager $transferFilesManager
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transfer(TransferFilesManager $transferFilesManager) {
        if (!session()->has('gmail-access-token')) {
            return redirect()->back()->with('error', 'Please authorize first user !');
        }
        if (!session()->has('drive-access-token')) {
            return redirect()->back()->with('error', 'Please authorize second user !');
        }

        $transferredFiles = $transferFilesManager->transfer('has:attachment :pdf label:inbox', 4, 'application/pdf');

        return redirect()->back()->with('transferredFiles', $transferredFiles);
    }
}
