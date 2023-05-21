<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;

class PullRequestController extends Controller
{
    public function getOldPullRequests()
    {
        try {

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
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error has occured while getting old pull requests']);
        }
       
    }

    public function getPullRequestsWithReviewRequired()
    {
        try{
            $client = new Client();

            $response = $client->get('https://api.github.com/search/issues', [
                'query' => [
                    'q' => 'repo:woocommerce/woocommerce is:pr is:open review:required',
                    'per_page' => 100,
                ],
            ]);

            $pullRequests = json_decode($response->getBody(), true)['items'];

            $this->writePullRequestsToFile('2-review-required-pull-requests.txt', $pullRequests);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error has occured while getting old pull requests with review required']);
        }
    }

    public function getPullRequestsWithSuccessfulReview()
    {
        try{
            $client = new Client();

            $response = $client->get('https://api.github.com/search/issues', [
                'query' => [
                    'q' => 'repo:woocommerce/woocommerce is:pr is:open status:success',
                    'per_page' => 100,
                ],
            ]);

            $pullRequests = json_decode($response->getBody(), true)['items'];

            $this->writePullRequestsToFile('3-review-successful-pull-requests.txt', $pullRequests);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error has occured while getting old pull requests with successful review']);
        }
    }

    public function getPullRequestsWithNoReviewsRequested()
    {
        try{
            $client = new Client();

            $response = $client->get('https://api.github.com/search/issues', [
                'query' => [
                    'q' => 'repo:woocommerce/woocommerce is:pr is:open -review:none',
                    'per_page' => 100,
                ],
            ]);

            $pullRequests = json_decode($response->getBody(), true)['items'];

            $this->writePullRequestsToFile('4-no-reviews-requested-pull-requests.txt', $pullRequests);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error has occured while getting old pull requests with no requested review']);
        }
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
