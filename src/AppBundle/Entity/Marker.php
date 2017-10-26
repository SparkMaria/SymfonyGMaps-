<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="marker")
 * @ORM\Entity
 */
class Marker {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     */
    protected $name;

    

    /**
     * @ORM\Column(name="lat", type="float")
     */
    protected $lat;

    /**
     * @ORM\Column(name="lng",type="float")
     */
    protected $lng;
    


    public function __construct() {

    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getLat() {
        return $this->lat;
    }

    function getLng() {
        return $this->lng;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setLat($lat) {
        $this->lat = $lat;
    }

    function setLng($lng) {
        $this->lng = $lng;
    }
    
    public function __toString() {
        return (string) $this->name;
    }

}
