<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use GuzzleHttp\Client;

class PullRequestController extends Controller
{
    public function getOldPullRequests()
    {
        $client = new Client();
        $twoWeeksAgo = Carbon::now()->subDays(14)->format('Y-m-d');

        $response = $client->get('https://api.github.com/search/issues', [
            'query' => [
                'q' => 'repo:woocommerce/woocommerce is:pr is:open created:<'.$twoWeeksAgo,
                'per_page' => 100,
            ],
        ]);

        $pullRequests = json_decode($response->getBody(), true)['items'];

        $this->writePullRequestsToFile('1-old-pull-requests.txt', $pullRequests);
    }

    private function writePullRequestsToFile($filename, $pullRequests)
    {
        $file = fopen($filename, 'w');

        foreach ($pullRequests as $pullRequest) {
            $line = 'PR#' . $pullRequest['number'] . ': ' . $pullRequest['title'] . ' (' . $pullRequest['html_url'] . ')';
            fwrite($file, $line . PHP_EOL);
        }

        fclose($file);
    }

}
