<?php
    return [

        'application_name' => env('GOOGLE_APPLICATION_NAME', ''),

        'client_id'        => env('GOOGLE_CLIENT_ID', ''),
        'client_secret'    => env('GOOGLE_CLIENT_SECRET', ''),
        'redirect_uri'     => env('GOOGLE_REDIRECT', ''),
        'scopes'           => [\Google_Service_Sheets::DRIVE, \Google_Service_Sheets::SPREADSHEETS],
        'access_type'      => 'online',
        'approval_prompt'  => 'force',
        'prompt'           => 'consent', 

        'developer_key'    => env('GOOGLE_DEVELOPER_KEY', ''),

        'service'          => [
            'enable' => env('GOOGLE_SERVICE_ENABLED', true),
            'file'   => env('GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION', storage_path('app') . '/' . env('GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION')),
        ],
        'config'           => [],
        'post_spreadsheet_id' => env('POST_SPREADSHEET_ID'),
        'post_sheet_id'       => env('POST_SHEET_ID'),
    ];