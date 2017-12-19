<?php
namespace KeriganSolutions\FacebookFeed;

use GuzzleHttp\Client;

class FacebookEvents extends FacebookFeed
{
    public function __construct()
    {
        parent::__construct();
    }

    public function fetch($limit = 5, $before = null, $after = null)
    {
        $fields = 'description,end_time,name,place,start_time,cover';
        try {
            $response = $this->get(
                '/' . $this->page_id .
                    '/events/?fields=' . $fields .
                    '&limit=' . $limit .
                    '&before=' . $before .
                    '&after=' . $after .
                    '&access_token=' . $this->access_token
            );

            $feed = json_decode($response->getBody());

            return $feed;
        } catch (ClientException $e) {
            // Most likely a bad token or improperly formatted request
            echo '<p>This content is currently unavailable due to an error.</p>';
        }
    }
}
