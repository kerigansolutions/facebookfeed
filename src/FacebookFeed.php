<?php
namespace KeriganSolutions\FacebookFeed;

/**
 * @version 0.14.0
 */

use GuzzleHttp\Client;
use KeriganSolutions\FacebookFeed\FacebookVideo;

class FacebookFeed
{
    /**
     * @param int $limit The number of posts to display
     * @return array
     */
    public function fetch($limit = 5, $before = null, $after = null)
    {
        $client = new Client([
            'base_uri' => 'https://graph.facebook.com/v2.11'
        ]);

        $page_id = FACEBOOK_PAGE_ID;
        $access_token = FACEBOOK_ACCESS_TOKEN;
        $fields = 'permalink_url,full_picture,message,object_id,type,status_type,caption,created_time,link,attachments{target,media}';

        $response = $client->request(
            'GET',
            '/' . $page_id . '/posts/?fields=' . $fields .
                '&limit=' . $limit .
                '&access_token=' . $access_token .
                '&before=' . $before .
                '&after=' . $after
        );

        $feed = json_decode($response->getBody());

        return $this->parse($feed);
    }

    protected function parse($feed)
    {
        $parsedFeed = [
            'posts' => [],
            'paging' => []
        ];

        foreach ($feed->data as $post) {
            if ($post->type == 'video') {
                $post->link = (new FacebookVideo($post))->handle()->link;
            }
            if ($post->type == 'event') {
                $post->full_picture = $this->getEventPhoto($post->attachments->data[0]->target->id);
            }
            if ($post->attachments->data[0]->media->image->width <= 100) {
                $post->full_picture = null;
            }
            array_push($parsedFeed['posts'], $post);
        }
        $parsedFeed['paging'] = $feed->paging;

        return (object) $parsedFeed;
    }

    protected function getEventPhoto($eventId)
    {
        $client = new Client(['base_uri' => 'https://graph.facebook.com/v2.11/']);

        $response = $client->request(
            'GET',
            $eventId .
                '?fields=photos{images}' .
                '&access_token=' . FACEBOOK_ACCESS_TOKEN
        );

        return json_decode($response->getBody())->photos->data[0]->images[0]->source;
    }
}
