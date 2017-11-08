# KMA WordPress Facebook Feed
Easily pull posts and events into your WordPress Site from a Facebook page that you manage.
## Installation
`composer require kerigansolutions/facebookfeed`
## Setup
Add your Facebook Page ID and Access Token to `wp-config.php`
```
define('FACEBOOK_PAGE_ID', 'YOUR FACEBOOK PAGE ID HERE');
define('FACEBOOK_ACCESS_TOKEN', 'YOUR FACEBOOK TOKEN HERE');
```
## Quick Start
```php

$feed          = new KeriganSolutions\FacebookFeed\FacebookFeed();
$numberOfPosts = 5;

$results = $feed->fetch($numberOfPosts);
echo '<pre>',print_r($results),'</pre>';
```

## Example results
*NOTE: This is just an example. Details and ids have been changed to protect identities.*
```
stdClass Object
(
    [data] => Array
        (
            [0] => stdClass Object
                (
                    [id] => 116881558417301_121234241564898
                    [message] => Lake After Hours and The Clinic of Baton Rouge welcome Dr. John Doe for a special Saturday Morning Clinic for high school athletes.

Saturday, September 30, 2017
9:00 am – 10:30 am 
3333 Example Lane, Baton Rouge
No appointment is necessary.

Dr. Doe is a Baton Rouge native and LSU Graduate. During orthopaedic surgery residency and sports medicine fellowship he served as a sports medicine physician for high school, college, and professional athletes including the University of Kentucky, University of Pittsburgh, Pittsburgh Steelers, and the Pittsburgh Penguins. His clinical and research focus has centered around ACL injury treatment and prevention. He has presented his research and instructional lectures at national and international sports medicine meetings.
                    [link] => https://www.facebook.com/bjcbr/photos/a.117190061719784.16056.116881558417301/1218738381564941/?type=3
                    [created_time] => 2017-09-29T13:44:52+0000
                    [updated_time] => 2017-09-29T13:44:52+0000
                    [picture] => https://scontent.xx.fbcdn.net/v/t1.0-0/s130x130/22046800_1218738381564941_6400256276981602099_n.jpg?oh=eb8aec4985807046120688f361e8d915&oe=5AA2D20A
                    [object_id] => 1218738381564941
                    [type] => photo
                )

        )
)
```
