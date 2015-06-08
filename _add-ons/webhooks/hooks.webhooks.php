<?php

header("Access-Control-Allow-Origin: *");
class Hooks_webhooks extends Hooks
{

    public function control_panel__add_to_foot()
    {
        return $this->js->link('webhooks');
    }

	/**
	 * GO! Do all the required things.
	 */
	public function webhooks__go()
	{
		
			
		$data = array();

		// Back out if the API isn't supplied or is incorrect
		if (Request::get('api_key') != $this->fetchConfig('api_key', Helper::getRandomString(), null, false, false)) {
			$app = \Slim\Slim::getInstance();
			$app->halt(403, 'Invalid API key.');
		}

		if ($this->config['clear_cache']) {
			$this->log->info('Statamic cache clearing is set to TRUE');

			// Clear the contents of Statamic's cache directory
			if ($this->config['ajax_notification'])
			{
				array_push($data, $this->clearStatamicCache());
			} else {
				$this->clearStatamicCache();
			}
		}

		if ($this->config['clear_php_opcache'] && function_exists('opcache_reset')) {
			$this->log->info('PHP OPcache is clearing set to TRUE');

			// Clear OpCache PHP cache storage installed as part of PHP5.5.*
			if ($this->config['ajax_notification'])
			{
				array_push($data, $this->clearOpCache());
			} else {
				$this->clearOpCache();
			}
		}

		if ($this->config['clear_html_caching']) {
			$this->log->info('Rendered HTML cache clearing is set to TRUE');

			// Clear rendered html cache
			if ($this->config['ajax_notification'])
			{
				array_push($data, $this->clearHtmlCache());
			} else {
				$this->clearHtmlCache();
			}
		}

		if ($this->config['clear_tag_cache']) {
			$this->log->info('Template cache clearing is set to TRUE');

			// Clear {{ cache }} template tag cache
			if ($this->config['ajax_notification'])
			{
				array_push($data, $this->clearTagCache());
			} else {
				$this->clearTagCache();
			}
		}

		if ( $this->config['clear_pagespeed_cache']) {
			$this->log->info('Mod_pagespeed cache clearing is set to TRUE');

			// Clear mod_pagespeed cache
			if ($this->config['ajax_notification'])
			{
				array_push($data, $this->clearPageSpeedCache());
			} else {
				$this->clearPageSpeedCache();
			}
		}

		if ($this->config['ajax_notification'])
		{
			header("Content-Type: application/json");
			exit(json_encode($data, JSON_PRETTY_PRINT));
		}
	}


	//---------------------------------------------


	private function clearStatamicCache()
	{
		$app_cache_folder = BASE_PATH . '/_cache/_app/';
		Folder::delete($app_cache_folder, true);
		
		$tag_cache_folder = BASE_PATH . '/_cache/_add-ons/cache/';
		Folder::delete($tag_cache_folder, true);
		
		$this->log->info(Localization::fetch('cms_cache_success'));
		return Localization::fetch('cms_cache_success');
	}

	private function clearOpCache()
	{
		opcache_reset();

		$this->log->info(Localization::fetch('opcache_success'));
		return Localization::fetch('opcache_success');
	}

	private function clearHtmlCache()
	{
		$cache_folder = BASE_PATH . '/_cache/_add-ons/html_caching/';
		Folder::delete($cache_folder, true);

		$this->log->info(Localization::fetch('html_cache_success'));
		return Localization::fetch('html_cache_success');
	}

	private function clearTagCache()
	{
		$cache_folder = BASE_PATH . '/_cache/_add-ons/cache/';
		Folder::delete($cache_folder, true);

		$this->log->info(Localization::fetch('tag_cache_success'));
		return Localization::fetch('tag_cache_success');
	}

	private function clearPageSpeedCache()
	{
		if (strpos(shell_exec('apache2ctl -M'), 'pagespeed_module') !== false || strpos(shell_exec('/usr/sbin/nginx-sp -V 2>&1 | grep -o ngx_pagespeed'), 'ngx_pagespeed') !== false)
		{
			$ch = curl_init();
			$cache_url = Config::getSiteURL();
			$cache_query = '/pagespeed_admin/cache?purge=*';

			curl_setopt($ch, CURLOPT_URL, $cache_url . $cache_query);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_NOBODY, 1);
			curl_exec($ch);
			curl_close($ch);

			$this->log->info(Localization::fetch('pagespeed_success'));
      		return Localization::fetch('pagespeed_success');
		} else {
			$this->log->info(Localization::fetch('pagespeed_failure'));
      		return Localization::fetch('pagespeed_failure');
		}
	}
}
