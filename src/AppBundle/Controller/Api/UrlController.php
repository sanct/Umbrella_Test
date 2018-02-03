<?php
/**
 * Created by PhpStorm.
 * User: sanct
 * Date: 27.01.2018
 * Time: 16:44
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Url;
use AppBundle\Utils\ShortUrl;
use FOS\RestBundle\{ Controller\FOSRestController, Routing\ClassResourceInterface, View\View };
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UrlController extends FOSRestController implements ClassResourceInterface
{
	private $logger;
	private $shortUrl;
	private $validator;

	public function __construct(
		LoggerInterface $logger,
		ShortUrl $short_url,
		ValidatorInterface $validator)
	{
		$this->logger = $logger;
		$this->shortUrl = $short_url;
		$this->validator = $validator;
	}

	/**
	 * @param int $id
	 *
	 * @return Url|null|object
	 */
	public function getAction(int $id)
	{
		$url = $this->getDoctrine()->getRepository('AppBundle:Url')->find($id);
		if(!$url instanceof Url)
		{
			return new View('Url not found', Response::HTTP_NOT_FOUND);
		}

		return $url;
	}

	/**
	 * @return Url[]|array
	 */
	public function cgetAction()
	{
		$urls = $this->getDoctrine()->getRepository('AppBundle:Url')->findAll();
		return $urls;
	}

	/**
	 * @param Request $request
	 *
	 * @return View|\Symfony\Component\Form\FormInterface
	 */
	public function postAction(Request $request)
	{
		$original = $request->get('original');
		$short = $request->get('short');
		$short = empty($short) ? $this->shortUrl->generateShortUrl() : $short;

		$url = new Url();
		$url->setOriginal($original);
		$url->setShort($short);

		$errors = $this->validator->validate($url);
		if ($errors->count() > 0)
		{
			$errorsString = (string)$errors->get(0);
			$this->logger->error($errorsString);

			return new View($errorsString, Response::HTTP_BAD_REQUEST);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($url);
		$em->flush();

		$this->logger->info('Short url: '.$short.' were created for original url: '.$original);
		return new View(['short' => $url->getShort()], Response::HTTP_CREATED);
	}
}