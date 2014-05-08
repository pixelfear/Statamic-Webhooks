# Webhooks for Statamic
> Need a way to do something after deploying (like clearing your cache)? Do it automatically!

## What happens?
This is what can happen when you hit the trigger URL.

* Clear your Statamic cache. (on by default)
* Clear your PHP OpCache (on by default if it's installed)
* Clear your [rendered HTML cache](http://statamic.com/learn/advanced-features/html-caching) (off by default)

All of these are customizable in `_config/add-ons/webhooks/webhooks.yaml`.

## That's all?
If you have suggestions or requests for other things to be performed automatically, [let me know on Twitter (@jason_varga)](https://twitter.com/jason_varga) or open a GitHub issue.

## Installation and Usage

* Copy `_add-ons/webhooks/` to your `_add-ons` directory.
* Copy `_config/add-ons/webhooks` to your `_config/add-ons` directory.
* Add an `api_key` to `_config/add-ons/webhooks/webhooks.yaml`. This can be anything you want.
* Optionally update the other values in `webhooks.yaml` to turn on/off functionality.

To trigger the actions, just hit the following URL after deployment.

    http://yoursite.com/TRIGGER/webhooks/go?api_key=[YOUR_API_KEY]

Replace `[YOUR_API_KEY]` with the `api_key` you created in the config file.