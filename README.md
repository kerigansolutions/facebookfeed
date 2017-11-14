# KMA WordPress Facebook Feed
Easily pull posts and events into your WordPress Site from a Facebook page that you manage.
## Installation
`composer require kerigansolutions/facebookfeed`
## Setup
### Get your Facebook Page ID and Access token
- Facebook Page ID
    1. Open your Facebook Page
    2. Click "About"
    3. Scroll down to the "More Info" section
    4. Under Page ID, you will find your page ID
- App Access Token
    + Create a new app in the [Facebook Developer Console](https://developers.facebook.com/apps/)
    + Use the [Access Token tool](https://developers.facebook.com/tools/accesstoken/) to retrieve your App Access Token

### Add your Facebook Page ID and Access Token to `wp-config.php`
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
