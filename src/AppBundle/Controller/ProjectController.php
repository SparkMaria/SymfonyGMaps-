<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Marker;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

class ProjectController extends Controller {

    /**
     * @Route("/map")
     */
    public function mapAction(Request $request) {

        if ($request->isMethod('GET')) {
            
            $em = $this->getDoctrine()->getManager();
            $locations = $em->getRepository('AppBundle:Marker')->findAll();
            dump($locations);
            $locations = $this->get('serializer')->serialize($locations, 'json');
            
            return $this->render('Route/map.html.twig', ['locations' => $locations]);
        }
        if ($request->isMethod('POST')) {
            $name_value = $request->request->get('name');
            $lat_value = $request->request->get('lat');
            $lng_value = $request->request->get('lng');

            $em = $this->getDoctrine()->getManager();


            $marker = new Marker();
            $marker->setName($name_value);
            $marker->setLat($lat_value);
            $marker->setLng($lng_value);

            $em->persist($marker);
            $em->flush();


            return new Response('ok' . $marker->getName());
        }
    }

    /**
     * @Route("/getLocations", name = "getLocations")
     */
    public function showMarkersAction(Request $request) {


        if ($request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();
            $locations = $em->getRepository('AppBundle:Marker')->findAll();
            
            $locations = $this->get('serializer')->serialize($locations, 'json');



            return new JsonResponse($locations);
        }
        if ($request->isMethod('GET')) {
            return new Response();
        }
    }

}
