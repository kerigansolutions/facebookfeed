<?php
namespace KeriganSolutions\FacebookFeed;

class FacebookVideo
{
    protected $post;

    public function __construct($post)
    {
        $this->post = $post;
    }
    public function handle()
    {
        if ($this->post->caption == 'vimeo.com') {
            return $this->convertLinkForVimeo();
        } else {
            $this->post->link = 'https://www.facebook.com/plugins/video.php?href='. $this->post->link;
            return $this->post;
        }
    }

    private function convertLinkForVimeo()
    {
        // Explosions everywhere!
        // TODO: Make this cleaner
        $initialExplosion = explode('?', $this->post->link);
        $finalExplosion   = explode('/', $initialExplosion[0]);
        $vimeoId          = array_pop($finalExplosion);
        $this->post->link = 'https://player.vimeo.com/video/' . $vimeoId .'?autoplay=0&portrait=0';

        return $this->post;
    }
}
