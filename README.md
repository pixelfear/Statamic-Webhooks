# Webhooks for Statamic
> Need a way to do something after deploying (like clearing your cache)? Do it automatically!

After deployment, just hit the following URL:

    http://yoursite.com/TRIGGER/webhooks/go

## What happens?
This is what can happen when you hit the trigger URL.

* Clear your Statamic cache. (on by default)
* Clear your PHP OpCache (on by default if it's installed)
* Clear your [rendered HTML cache](http://statamic.com/learn/advanced-features/html-caching) (off by default)

All of these are customizable in `_config/add-ons/webhooks/webhooks.yaml`.

## That's all?
If you have suggestions or requests for other things to be performed automatically, [let me know on Twitter (@jason_varga)](https://twitter.com/jason_varga) or open a GitHub issue.