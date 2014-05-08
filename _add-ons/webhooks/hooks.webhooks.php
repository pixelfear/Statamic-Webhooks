<?php

class Hooks_webhooks extends Hooks
{

	/**
	 * GO! Do all the required things.
	 */
	public function webhooks__go()
	{
		if ($this->config['clear_cache']) {
			// Clear the contents of Statamic's cache directory
			$this->clearStatamicCache();
		}

		if ($this->config['clear_php_opcache'] && function_exists('opcache_reset')) {
			// Clear OpCache PHP cache storage installed as part of PHP5.5.*
			$this->clearOpCache();
		}

		if ($this->config['clear_html_caching']) {
			// Clear rendered html cache
			$this->clearHtmlCache();
		}
	}


	//---------------------------------------------


	private function clearStatamicCache()
	{
		$cache_folder = BASE_PATH . '/_cache/_app/';
		Folder::delete($cache_folder, true);
		$this->log->info('Statamic\'s cache has been cleared.');
	}

	private function clearOpCache()
	{
		opcache_reset();
		$this->log->info('OpCache has been cleared.');
	}

	private function clearHtmlCache()
	{
		$cache_folder = BASE_PATH . '/_cache/_add-ons/html_caching/';
		Folder::delete($cache_folder, true);
		$this->log->info('Rendered HTML cache has been cleared.');
	}

}
