# KMA WordPress Facebook Feed
Easily pull posts and events into your WordPress Site from a Facebook page that you manage.
## Installation
`composer require kerigansolutions/facebookfeed`
## Setup
### Get your Facebook Page ID and Access token
- Facebook Page ID
    + Open your Facebook Page
    + Click "About"
    + Scroll down to the "More Info" section
    + Under Page ID, you will find your page ID
- App Access Token
    + Create a new app in the [Facebook Developer Console](https://developers.facebook.com/apps/)
    + Use the [Access Token tool](https://developers.facebook.com/tools/accesstoken/) to retrieve your App Access Token

- Add your Facebook Page ID and Access Token to `wp-config.php`
```
define('FACEBOOK_PAGE_ID', 'YOUR FACEBOOK PAGE ID HERE');
define('FACEBOOK_ACCESS_TOKEN', 'YOUR FACEBOOK TOKEN HERE');
```
## Quick Start
```php

$facebookFeed  = new KeriganSolutions\FacebookFeed\FacebookFeed();
$numberOfPosts = 1;

$results = $facebookFeed->fetch($numberOfPosts);

echo '<pre>',print_r($results),'</pre>';

```
## Pagination
This package uses the default cursor-based pagination that is returned by the Facebook Graph API. Let's take a look at how to implement this in our WordPress site:
### Make the API call and retrieve the results:
```php
$facebookFeed  = new KeriganSolutions\FacebookFeed\FacebookFeed();
$numberOfPosts = 5;

$results = $facebookFeed->fetch($numberOfPosts);
```
We've covered this already. So far, so good. Let's look at the returned data:
```json
{
  "data": [
    {
      // Data
    }
  ],
  "paging": {
    "cursors": {
      "before": "Q2c4U1pXNTBYM0YxWlhKNVgzTjBiM0o1WDJsa0R5TXhOamMyTkRRNU5EazVNVGswTkRrNk1UVXhPVEkyTlRJME1URTBOekV6TnpBNU1BOE1ZAWEJwWDNOMGIzSjVYMmxrRHlBeE5qYzJORFE1TkRrNU1UazBORGxmTVRrMU9UUTNNRFl5TkRBM01ERTVOdzhFZAEdsdFpRWmFDdFh2QVE9PQZDZD",
      "after": "Q2c4U1pXNTBYM0YxWlhKNVgzTjBiM0o1WDJsa0R5TXhOamMyTkRRNU5EazVNVGswTkRrNk1UVXhPVEkyTlRJME1URTBOekV6TnpBNU1BOE1ZAWEJwWDNOMGIzSjVYMmxrRHlBeE5qYzJORFE1TkRrNU1UazBORGxmTVRrMU9UUTNNRFl5TkRBM01ERTVOdzhFZAEdsdFpRWmFDdFh2QVE9PQZDZD"
    },
    "next": "https://graph.facebook.com/v2.11/167644949919449/posts?access_token=*******************************&pretty=0&fields=full_picture%2Cmessage%2Cobject_id%2Ctype%2Cstatus_type%2Ccaption%2Ccreated_time%2Clink%2Cupdated_time&limit=1&after=Q2c4U1pXNTBYM0YxWlhKNVgzTjBiM0o1WDJsa0R5TXhOamMyTkRRNU5EazVNVGswTkRrNk1UVXhPVEkyTlRJME1URTBOekV6TnpBNU1BOE1ZAWEJwWDNOMGIzSjVYMmxrRHlBeE5qYzJORFE1TkRrNU1UazBORGxmTVRrMU9UUTNNRFl5TkRBM01ERTVOdzhFZAEdsdFpRWmFDdFh2QVE9PQZDZD"
  }
}
```

From the [Facebook Graph API docs](https://developers.facebook.com/docs/graph-api/using-graph-api):
>A cursor-paginated edge supports the following parameters:



