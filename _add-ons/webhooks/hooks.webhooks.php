<?php

class Hooks_webhooks extends Hooks
{

	public function webhooks__go()
	{
		if ($this->fetchConfig('clear_cache', true, null, true)) {
			// Clear the contents of Statamic's cache directory
			$this->clearStatamicCache();
			
			// Clear OpCache PHP cache storage installed as part of PHP5.5.*
			if (function_exists('opcache_reset')) {
				$this->clearOpCache();
			}
		}

	}

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

}
