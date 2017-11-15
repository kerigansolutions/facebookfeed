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
        if ($this->post->caption == 'youtube.com') {
            return $this->convertLinkForYoutube();
        } elseif ($this->post->caption == 'vimeo.com') {
            return $this->convertLinkForVimeo();
        } else {
            $this->post->link = 'https://www.facebook.com/plugins/video.php?href='. $this->post->link;
            return $this->post;
        }
    }

    private function convertLinkForVimeo()
    {
        $vimeoId = parse_url($this->post->link, PHP_URL_PATH);
        $this->post->link = 'https://player.vimeo.com/video' . $vimeoId .'?autoplay=0';

        return $this->post;
    }
    private function convertLinkForYoutube()
    {
        parse_str(parse_url($this->post->link, PHP_URL_QUERY), $urlArray);
        $this->post->link = 'https://youtube.com/embed/'. $urlArray['v'];

        return $this->post;
    }
}
