<?php
namespace KeriganSolutions\FacebookFeed;

use GuzzleHttp\Client;

class FacebookEvents
{
    public function fetch($limit = 5, $before = null, $after = null)
    {
        $client = new Client([
            'base_uri' => 'https://graph.facebook.com/v2.9'
        ]);

        $page_id      = FACEBOOK_PAGE_ID;
        $access_token = FACEBOOK_ACCESS_TOKEN;
        $fields       = 'description,end_time,name,place,start_time,cover';
        $response     = $client->request(
            'GET',
            '/' . $page_id . '/events/?fields='. $fields .
            '&limit='        . $limit .
            '&before='       . $before .
            '&after='        . $after .
            '&access_token=' . $access_token
        );

        $feed = json_decode($response->getBody());

        return $feed;
    }
}
