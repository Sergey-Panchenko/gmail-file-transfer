<?php

namespace App\Http\Controllers;

use App\Repositories\GDriveRepository;
use App\Repositories\GmailRepository;
use App\Services\GDriveService;
use App\Services\GmailService;
use Illuminate\Http\Request;

class GoogleClientController extends Controller
{

    /**
     * Callback for google drive client.
     *
     * @param Request $request
     *
     * @param GDriveService $driveService
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function driveAuthCallback(Request $request, GDriveService $driveService)
    {
        $authCode = $this->fetchAuthCode($request);
        $accessToken = $driveService->fetchAccessTokenWithAuthCode($authCode);
        $this->validateAccessToken($accessToken);
        $driveService->saveAccessToken($accessToken);

        return redirect('/');
    }

    /**
     * Callback for gmail client.
     *
     * @param Request $request
     *
     * @param GmailService $gmailService
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function gmailAuthCallback(Request $request, GmailService $gmailService)
    {
        $authCode = $this->fetchAuthCode($request);
        $accessToken = $gmailService->fetchAccessTokenWithAuthCode($authCode);
        $this->validateAccessToken($accessToken);
        $gmailService->saveAccessToken($accessToken);

        return redirect('/');
    }

    /**
     * Get auth code from request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function fetchAuthCode(Request $request)
    {
        $request->validate(['code' => 'required']);
        return $request->get('code');
    }

    /**
     * Validate access token.
     *
     * @param array $accessToken
     */
    public function validateAccessToken($accessToken)
    {
        if (!empty($accessToken['error'])) {
            throw new \RuntimeException($accessToken['error_description']);
        }
    }

    /**
     * Logout gmail user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function gmailLogout()
    {
        session()->forget('gmail-access-token');
        return redirect()->back();
    }

    /**
     * Logout google drive user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function driveLogout()
    {
        session()->forget('drive-access-token');
        return redirect()->back();
    }

}
