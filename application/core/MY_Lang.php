<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
* Language Identifier
*
* Adds a language identifier prefix to all site_url links
*
* @copyright     Copyright (c) 2011 Wiredesignz
* @version       0.29
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*/

class MY_Lang extends CI_Lang
{
	function __construct()
	{
		global $URI, $CFG, $IN;

		$config =& $CFG->config;

		$index_page = $config['index_page'];
		$lang_ignore = $config['lang_ignore'];
		$default_abbr = $config['language_code'];
		$lang_uri_abbr = $config['lang_uri_abbr'];

		/* get the language abbreviation from uri */
		$uri_abbr = $URI->segment(1);

		/* adjust the uri string leading slash */
		$URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);

		if ($lang_ignore) {

			if (isset($lang_uri_abbr[$uri_abbr])) {

				/* set the language_abbreviation cookie */
				$IN->set_cookie('user_lang', $uri_abbr, $config['sess_expiration']);

			} else {

				/* get the language_abbreviation from cookie */
				$lang_abbr = $IN->cookie($config['cookie_prefix'] . 'user_lang');

			}

			if (strlen($uri_abbr) == 2) {

				/* reset the uri identifier */
				$index_page .= empty($index_page) ? '' : '/';

				/* remove the invalid abbreviation */
				$URI->uri_string = preg_replace("|^\/?$uri_abbr\/?|", '', $URI->uri_string);

				/* redirect */
				header('Location: ' . $config['base_url'] . $index_page . $URI->uri_string);
				exit;
			}

		} else {

			/* set the language abbreviation */
			$lang_abbr = $uri_abbr;
		}

		/* check validity against config array */
		if (isset($lang_uri_abbr[$lang_abbr])) {

			/* reset uri segments and uri string */
			$URI->segment(array_shift($URI->segments));
			$URI->uri_string = preg_replace("|^\/?$lang_abbr|", '', $URI->uri_string);

			/* set config language values to match the user language */
			$config['language'] = $lang_uri_abbr[$lang_abbr];
			$config['language_code'] = $lang_abbr;

			/* if abbreviation is not ignored */
			if (!$lang_ignore) {

				/* check and set the uri identifier */
				$index_page .= empty($index_page) ? $lang_abbr : "/$lang_abbr";

				/* reset the index_page value */
				$config['index_page'] = $index_page;
			}

			/* set the language_abbreviation cookie */
			$IN->set_cookie('user_lang', $lang_abbr, $config['sess_expiration']);

		} else {

			/* if abbreviation is not ignored */
			if (!$lang_ignore) {

				/* check and set the uri identifier to the default value */
				$index_page .= empty($index_page) ? $default_abbr : "/$default_abbr";

				if (strlen($lang_abbr) == 2) {

					/* remove invalid abbreviation */
					$URI->uri_string = preg_replace("|^\/?$lang_abbr|", '', $URI->uri_string);
				}

				/* redirect */
				header('Location: ' . $config['base_url'] . $index_page . $URI->uri_string);
				exit;
			}

			/* set the language_abbreviation cookie */
			$IN->set_cookie('user_lang', $default_abbr, $config['sess_expiration']);
		}

		log_message('debug', "Language_Identifier Class Initialized");
	}

	/**
	 * @param mixed $langfile
	 * @param string $idiom
	 * @param bool $return
	 * @param bool $add_suffix
	 * @param string $alt_path
	 * @return array|bool|void
	 */
	public function load($langfile, $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '')
	{
		if (is_array($langfile))
		{
			foreach ($langfile as $value)
			{
				$this->load($value, $idiom, $return, $add_suffix, $alt_path);
			}

			return;
		}

		$langfile = str_replace('.php', '', $langfile);

		if ($add_suffix === TRUE)
		{
			$langfile = preg_replace('/_lang$/', '', $langfile).'_lang';
		}

		$langfile .= '.php';

		if (empty($idiom) OR ! preg_match('/^[a-z_-]+$/i', $idiom))
		{
			$config =& get_config();
			$idiom = empty($config['language']) ? 'english' : $config['language'];
		}

		if ($return === FALSE && isset($this->is_loaded[$langfile]) && $this->is_loaded[$langfile] === $idiom)
		{
			return;
		}

		// Load the base file, so any others found can override it
		$basepath = BASEPATH.'language/'.$idiom.'/'.$langfile;
		if (($found = file_exists($basepath)) === TRUE)
		{
			include($basepath);
		}

		// Do we have an alternative path to look in?
		if ($alt_path !== '')
		{
			$alt_path .= 'language/'.$idiom.'/'.$langfile;
			if (file_exists($alt_path))
			{
				include($alt_path);
				$found = TRUE;
			}
		}
		else
		{
			foreach (get_instance()->load->get_package_paths(TRUE) as $package_path)
			{
				$package_path .= 'language/'.$idiom.'/'.$langfile;
				if ($basepath !== $package_path && file_exists($package_path))
				{
					include($package_path);
					$found = TRUE;
					break;
				}
			}
		}

		if ($found !== TRUE)
		{
			// Get default language
			if ($idiom != '' and $idiom != DEFAULT_LANGUAGE)
			{
				$this->load($langfile, DEFAULT_LANGUAGE, $return, $add_suffix, $alt_path);
			}
			else
			{
				show_error('Unable to load the requested language file: language/'.$idiom.'/'.$langfile);
			}
		}

		if ( ! isset($lang) OR ! is_array($lang))
		{
			log_message('error', 'Language file contains no data: language/'.$idiom.'/'.$langfile);

			if ($return === TRUE)
			{
				return array();
			}
			return;
		}

		if ($return === TRUE)
		{
			return $lang;
		}

		$this->is_loaded[$langfile] = $idiom;
		$this->language = array_merge($this->language, $lang);

		log_message('info', 'Language file loaded: language/'.$idiom.'/'.$langfile);
		return TRUE;
	}
}