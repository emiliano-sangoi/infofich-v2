<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Vehiculo")
 * 
 */
class Vehiculo
{   
    
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vechicleTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $VechilcleOverview;

    /**
     * @ORM\Column(type="integer")
     */
    private $PrricePerDay;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $FuelType;

    /**
     * @ORM\Column(type="date")
     */
    private $ModelYear;

    /**
     * @ORM\Column(type="integer")
     */
    private $SeatingCapacity;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Vimage1;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Vimage2;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Vimage;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $AirConditioner;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $PowerDoorLocks;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $AntiLockBraking;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $BreakAssist;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $PowerSteering;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $DriverAirBag;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $regDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $UpdationDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brands",inversedBy="Vechicles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brands;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Membres", mappedBy="vechicles")
     */
    private $membres;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Booking", mappedBy="vechicles", cascade={"persist", "remove"})
     */
    private $booking;
    
}
