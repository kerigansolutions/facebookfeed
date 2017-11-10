<?php
namespace KeriganSolutions\FacebookFeed;

/**
 * @version 0.5
 */

use GuzzleHttp\Client;

class FacebookFeed
{
    /**
     * @param int $limit The number of posts to display
     * @return array
     */
    public function fetch($limit = 5)
    {
        $client = new Client([
            'base_uri' => 'https://graph.facebook.com/v2.11'
        ]);

        $page_id      = FACEBOOK_PAGE_ID;
        $access_token = FACEBOOK_ACCESS_TOKEN;
        $fields       = 'full_picture,message,object_id,type,status_type,caption,created_time,link,updated_time';
        $response     = $client->request('GET', '/' . $page_id . '/posts/?fields=' . $fields . '&limit=' . $limit . '&access_token=' . $access_token);
        $feed         = json_decode($response->getBody());
        return $this->filter($feed);
    }

    protected function filter($feed)
    {
        $filteredFeed = [];

        foreach ($feed->data as $post) {
            if ($post->status_type != 'shared_story') {
                array_push($filteredFeed, $post);
            }
        }

        return $filteredFeed;
    }
}
