<?php
namespace KeriganSolutions\FacebookFeed;

/**
 * @version 0.16.0
 */

use GuzzleHttp\Client;
use KeriganSolutions\FacebookFeed\FacebookVideo;
use GuzzleHttp\Exception\ClientException;

class FacebookFeed
{
    protected $client;
    protected $page_id;
    protected $access_token;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://graph.facebook.com/v2.11']);
        $this->page_id = FACEBOOK_PAGE_ID;
        $this->access_token = FACEBOOK_ACCESS_TOKEN;
    }

    /**
     * @param int $limit The number of posts to display
     * @return array
     */
    public function fetch($limit = 5, $before = null, $after = null)
    {
        $fields = 'permalink_url,full_picture,message,object_id,type,status_type,caption,created_time,link,attachments{target,media}';
        try {
            $response = $this->get(
                '/' . $this->page_id .
                    '/posts/?fields=' . $fields .
                    '&limit=' . $limit .
                    '&access_token=' . $this->access_token .
                    '&before=' . $before .
                    '&after=' . $after
            );

            $feed = json_decode($response->getBody());

            return $this->parse($feed);
        } catch (ClientException $e) {
            // Most likely a bad token or improperly formatted request
            echo '<p>This content is currently unavailable due to an error.</p>';
        }
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

        return (object)$parsedFeed;
    }

    protected function getEventPhoto($eventId)
    {
        $response = $this->get($eventId . '?fields=photos{images}' . '&access_token=' . $this->access_token);

        return json_decode($response->getBody())->photos->data[0]->images[0]->source;
    }

    protected function get($params)
    {
        return $this->client->request('GET', $params);
    }
}
