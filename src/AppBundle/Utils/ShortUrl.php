<?php
/**
 * Created by PhpStorm.
 * User: sanct
 * Date: 25.01.2018
 * Time: 23:34
 */

namespace AppBundle\Utils;

class ShortUrl
{
	/**
	 * @return bool|string
	 */
	public function generateShortUrl()
	{
		return substr(md5(rand()), 0, 10);
	}

	/**
	 * @param string $original_url
	 *
	 * @return bool
	 */
	public function isActiveUrl(string $original_url)
	{
		try
		{
			$headers = get_headers($original_url, 1);
			return (substr($headers[0],9,3) == 200);
		}
		catch (\Exception $exception)
		{
			return false;
		}
	}
}