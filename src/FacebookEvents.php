<?php
namespace KeriganSolutions\FacebookFeed;

use Carbon\Carbon;
use GuzzleHttp\Client;

class FacebookEvents
{
    public function fetch($limit = 5, $before = null, $after = null)
    {
        $response = $this->getEvents($limit, $before, $after);

        return $this->sortEvents(json_decode($response->getBody()));
    }

    protected function getEvents($limit, $before, $after)
    {
        $client = new Client([
            'base_uri' => 'https://graph.facebook.com/v2.11'
        ]);

        $page_id = FACEBOOK_PAGE_ID;
        $access_token = FACEBOOK_ACCESS_TOKEN;
        $fields = 'description,end_time,name,place,start_time,cover';

        return $client->request(
            'GET',
            '/' . $page_id .
            '/events/?fields=' . $fields .
            '&limit=' . $limit .
            '&before=' . $before .
            '&after=' . $after .
            '&access_token=' . $access_token
        );
    }

    private function sortEvents($events)
    {
        foreach ($events->data as $event) {
            $event->unixTime = Carbon::parse($event->start_time)->timestamp;
        }

        usort($events->data, function ($a, $b) {
            return ($a->unixTime > $b->unixTime);
        });

        return $events;
    }
}
