<?php 
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
//use Vich\UploaderBundle\Templating\Helper\UploaderHelper; // trouver un chemin



class AdminPropertyController extends AbstractController
{
	/**
	*@var PropertyRepository
	*/
	private $repository;


	public function __construct(PropertyRepository $repository, ObjectManager $em)
	{
		$this->repository = $repository;
		$this->em = $em;
	}

	/**
	*@Route ("/admin" , name ="admin.property.index")
	*@return \Symfony\Component\HttpFoundation\Response
	*/
	public function index()
	{
		$properties = $this->repository->findAll();
		return $this->render('admin/property/index.html.twig', compact('properties'));
	}

	/**
	*@Route ("/admin/property/create", name="admin.property.new")
	*/
	public function new(Request $request)
	{
		$property = new Property();
		$form = $this->createForm(PropertyType::class, $property);
		$form->handleRequest($request);


		if ($form->isSubmitted() && $form->isValid()) {
				$this->em->persist($property); //pour etre traquée par l'ObjectManager
				$this->em->flush(); // Porter le infos vers la BDD
				$this->addFlash('success', 'Bien crée avec succès'); //message de réussite de l'action
				return $this->redirectToRoute('admin.property.index');
			}
			return $this->render('admin/property/new.html.twig', ['property' => $property, 'form' => $form->createView()]);
	}

	/**
	*@Route ("/admin/property/{id}" , name ="admin.property.edit", methods="GET|POST")
	*@param Property $property
	*@return \Symfony\Component\HttpFoundation\Response
	*/
	public function edit(Property $property, Request $request) //CacheManager $cacheManager, UploaderHelper $helper
	{
		//$option = new Option();
		//$property->addOption($option);

		$form = $this->createForm(PropertyType::class, $property);
	 	$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
		/*	if($property->getImageFile() instanceof UploadedFile) //Y Pour vider le cache
			{
				$cacheManager->remove($helper->asset($property, 'imageFile'));
			}
		*/
				$this->em->flush();      // Porter le infos vers la BDD
				$this->addFlash('success', 'Bien modifié avec succès'); //message de réussite de l'action
				return $this->redirectToRoute('admin.property.index'); //Redirection
		}

		return $this->render('admin/property/edit.html.twig', ['property' => $property, 'form' => $form->createView()]);
	}

	/**
	*@Route ("/admin/property/{id}" , name ="admin.property.delete", methods="DELETE")
	*@param Property $property
	*@return \Symfony\Component\HttpFoundation\RedirectResponse
	*/
	public function delete(Property $property, Request $request)
	{
		if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token'))){
			
		$this->em->remove($property); //suppression
		$this->em->flush(); // Porter le infos vers la BDD
		$this->addFlash('success', 'Bien supprimé avec succès'); //message de réussite de l'action
		
		}
		return $this->redirectToRoute('admin.property.index');
	}
}