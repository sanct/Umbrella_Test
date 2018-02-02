<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Url;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
	private $logger;

	public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	/**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

	/**
	 * @Route("/{short}", name="short")
	 * @param string $short
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
    public function shortIndex(string $short)
    {
		$url = $this->getDoctrine()->getRepository(Url::class)->getOneByShort($short);
	    if(!$url instanceof Url)
	    {
	    	$this->logger->error('Url '.$short.' no longer exists or not found');
		    return $this->redirectToRoute('homepage');
	    }

	    $url->incrementAmount();
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($url);
	    $em->flush();

	    $this->logger->info('Following a link: '.$short.', amount: '.$url->getAmount());
	    return $this->redirect($url->getOriginal());
    }
}
