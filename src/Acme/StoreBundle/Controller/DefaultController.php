<?php

namespace Acme\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\StoreBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Acme\StoreBundle\Entity\Task;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
	
    /**
     * @Route("/hello")
     * @Template()
     */
	public function createAction()
	{
		$product = new Product();
		$product->setName('A Foo Bar');
		$product->setPrice('19.99');
		$product->setDescription('Lorem ipsum dolor');

		$em = $this->getDoctrine()->getManager();
		$em->persist($product);
		$em->flush();

		return new Response('Created product id '.$product->getId());
	}
    /**
     * @Route("/forma", name="forma")
     * @Template()
     */
	public function newAction(Request $request)
	{
		// just setup a fresh $task object (remove the dummy data)
		/*$task = new Task();

		$form = $this->createFormBuilder($task)
			->add('task', 'text')
			->add('dueDate', 'date')
			->add('save', 'submit', array('label' => 'Create Post'))
			->getForm();*/
			
		$product = new Product();	
			
		$form = $this->createFormBuilder($product)
			->add('name', 'text')
			->add('price', 'number')
			->add('description', 'text')
			->add('save', 'submit', array('label' => 'Create Post'))
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted()) {
			
			/*$product = new Product();
			$product->setName('A Foo Bar222');
			$product->setPrice('13.74');
			$product->setDescription('Lorem ipsum');*/

			$em = $this->getDoctrine()->getManager();
			$em->persist($product);
			$em->flush();

			return $this->redirect($this->generateUrl('forma'));
		}
		
		$repository = $this->getDoctrine()
    ->getRepository('AcmeStoreBundle:Product');
	
		$products = $repository->findAll();
		
		 return $this->render('AcmeStoreBundle:Default:new.html.twig', array(
            'form' => $form->createView(), 'products' => $products
        ));
	}
	
	    /**
     * @Route("success", name="task_success")
     * @Template()
     */
    public function successAction()
    {
        return array();
    }
}
