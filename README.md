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
      // Facebook Post Data is in here, but we're concerned with the paging
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

    before : This is the cursor that points to the start of the page of data that has been returned.
    after : This is the cursor that points to the end of the page of data that has been returned.
    limit : This is the maximum number of objects that may be returned. A query may return fewer than the limit value due to filtering. Do not depend on the number of results being fewer than the limit value to indicate your query reached the end of the list of data, use the absence of next instead as described below. For example, if you set limit to 20, 20 objects will be found but, due to privacy filtering, only 9 are shown. If you reset limit to 40, 40 objects will be found but, again due to filtering, only 12 are returned. If there is no result in your search, there will be no pagination and no indication that more items are available, though there can be more items if you increase limit. Some edges may also have a maximum on the limit value for performance reasons.
    next : The Graph API endpoint that will return the next page of data. If not included, this is the last page of data. Due to how pagination works with visibility and privacy, it is possible that a page may be empty but contain a 'next' paging link. Stop paging when the 'next' link no longer appears.
    previous : The Graph API endpoint that will return the previous page of data. If not included, this is the first page of data.



