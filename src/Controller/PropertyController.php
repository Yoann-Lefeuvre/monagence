<?php
namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use App\Repository\PropertyRepository;
use App\Repository\Query;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class PropertyController extends AbstractController
{

	/**
	*@var PropertyRepository
	*/
	private $repository;

	public function __construct(PropertyRepository $repository, ObjectManager $manager)
	{
				$this->repository = $repository;
				$this->manager = $manager;
	}

	/**
	*@Route("/biens", name="property.index" ) 
	*@return Response
	*/
	public function index(PaginatorInterface $paginator, Request $request):Response
	{
		// Comment générer un systeme de recherche ? :
		// créer une entité qui va représenter notre recherche
		// créer un formulaire qui va représenter notre recherche
		// gérer le traitement dans le controller
		$search = new PropertySearch();
		$form = $this->createform(PropertySearchType::class, $search);
		$form->handleRequest($request); //Y-Doit gérer la requête

		$property = $paginator->paginate(
			$this->repository->findAllVisibleQuery($search),
			$request->query->getInt('page',1),
			12
		);


		//$property = $this->repository->findAllVisible();
		
		/*  //insertion d'un bien dans la BD
		$property = new Property;
		$property->setTitle('Mon premier bien')
				->setPrice(200000)
				->setRooms(4)
				->setBedrooms(3)
				->setDescription('Une petite description du bien à louer')
				->setSurface(60)
				->setFloor(4)
				->setHeat(1)
				->setCity('Nantes')
				->setAddress('15 Rue de la démo')
				->setPostalCode('44000');
				
			$em = $this->getDoctrine()->getManager();
			$em->persist($property); //persiste la propriété property
			$em->flush();  //envoi des changements de entity manager en base de donnée
		*/
				//Récupérer un bien dans la BD
		//Méthode 1 sans le constructeur PropertyRepository
			/*
			$repository = $this->getDoctrine()->getRepository(Property::class);
			dump($repository);
		*/
		//Méthode 2 avec le constructeur PropertyRepository
		/*
		$property = $this->repository->findAllVisible(); //findAll() pour récupérer tous les biens // findOneBy(['floor' => 4]);
		dump($property);
		*/

		/*   //Modifier les données
		$property[0]->setSold('true');
		$this->manager->flush();
		*/
	return $this->render('property/biens.html.twig', [ 'current_menu' => 'properties', 'properties' => $property, 'form' => $form->createView() ]);
	
	}

	/**
	*@Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"} ) 
	*@param Property $property
	*@return Response
	*/
	public function show(Property $property,String $slug,int $id, Request $request,ContactNotification $notification):Response
	{
		if ($property->getSlug() !== $slug)
		{
			return $this->redirectToRoute('property.show', ['id' => $property->getId(), 'slug' => $property->getSlug()], 301);
		}

		$contact = new Contact();
		$contact->setProperty($property);
		$form = $this->createform(ContactType::class, $contact);
		$form->handleRequest($request); //Y-  Gérer la requête

			if($form->isSubmitted() && $form->isValid())
			{

				$notification->notify($contact);

				//mail('contact@test.fr', 'MailDev test', 'Contenu du mail à consulter depuis MailDev', 'From: info@societe.com');
				$this->addFlash('success','Votre Email à bien été envoyé ');
				return $this->redirectToRoute('property.show', ['id' => $property->getId(), 'slug' => $property->getSlug()]);
			}

	



		$property = $this->repository->find($id);
		return $this->render('property/show.html.twig', ['property' => $property, 'current_menu' => 'properties', 'form' => $form->createView()]);
	}
}