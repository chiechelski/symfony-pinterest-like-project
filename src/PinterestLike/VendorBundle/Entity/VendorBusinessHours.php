<?php

namespace PinterestLike\VendorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VendorBusinessHours
 */
class VendorBusinessHours
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="monday_start", type="time", nullable=true)
     */
    private $mondayStart;

    /**
     * @var \DateTime
     * @ORM\Column(name="monday_end", type="time", nullable=true)
     */
    private $mondayEnd;

    /**
     * @var \DateTime
     * @ORM\Column(name="tuesday_start", type="time", nullable=true)
     */
    private $tuesdayStart;

    /**
     * @var \DateTime
     * @ORM\Column(name="tuesday_end", type="time", nullable=true)
     */
    private $tuesdayEnd;

    /**
     * @var \DateTime
     * @ORM\Column(name="wednesday_start", type="time", nullable=true)
     */
    private $wednesdayStart;

    /**
     * @var \DateTime
     * @ORM\Column(name="wednesday_end", type="time", nullable=true)
     */
    private $wednesdayEnd;

    /**
     * @var \DateTime
     * @ORM\Column(name="thrusday_start", type="time", nullable=true)
     */
    private $thursdayStart;

    /**
     * @var \DateTime
     * @ORM\Column(name="thursday_end", type="time", nullable=true)
     */
    private $thursdayEnd;

    /**
     * @var \DateTime
     * @ORM\Column(name="friday_start", type="time", nullable=true)
     */
    private $fridayStart;

    /**
     * @var \DateTime
     * @ORM\Column(name="friday_end", type="time", nullable=true)
     */
    private $fridayEnd;

    /**
     * @var \DateTime
     * @ORM\Column(name="saturday_start", type="time", nullable=true)
     */
    private $saturdayStart;

    /**
     * @var \DateTime
     * @ORM\Column(name="saturday_end", type="time", nullable=true)
     */
    private $saturdayEnd;

    /**
     * @var \DateTime
     * @ORM\Column(name="sunday_start", type="time", nullable=true)
     */
    private $sundayStart;

    /**
     * @var \DateTime
     * @ORM\Column(name="sunday_end", type="time", nullable=true)
     */
    private $sundayEnd;

    /**
     * @ORM\OneToOne(targetEntity="PinterestLike\VendorBundle\Entity\Vendor", inversedBy="businessHours")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id", nullable=false)
     */
    protected $vendor;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mondayStart
     *
     * @param \DateTime $mondayStart
     * @return VendorBusinessHours
     */
    public function setMondayStart($mondayStart)
    {
        $this->mondayStart = $mondayStart;

        return $this;
    }

    /**
     * Get mondayStart
     *
     * @return \DateTime 
     */
    public function getMondayStart()
    {
        return $this->mondayStart;
    }

    /**
     * Set mondayEnd
     *
     * @param \DateTime $mondayEnd
     * @return VendorBusinessHours
     */
    public function setMondayEnd($mondayEnd)
    {
        $this->mondayEnd = $mondayEnd;

        return $this;
    }

    /**
     * Get mondayEnd
     *
     * @return \DateTime 
     */
    public function getMondayEnd()
    {
        return $this->mondayEnd;
    }

    /**
     * Set tuesdayStart
     *
     * @param \DateTime $tuesdayStart
     * @return VendorBusinessHours
     */
    public function setTuesdayStart($tuesdayStart)
    {
        $this->tuesdayStart = $tuesdayStart;

        return $this;
    }

    /**
     * Get tuesdayStart
     *
     * @return \DateTime 
     */
    public function getTuesdayStart()
    {
        return $this->tuesdayStart;
    }

    /**
     * Set tuesdayEnd
     *
     * @param \DateTime $tuesdayEnd
     * @return VendorBusinessHours
     */
    public function setTuesdayEnd($tuesdayEnd)
    {
        $this->tuesdayEnd = $tuesdayEnd;

        return $this;
    }

    /**
     * Get tuesdayEnd
     *
     * @return \DateTime 
     */
    public function getTuesdayEnd()
    {
        return $this->tuesdayEnd;
    }

    /**
     * Set wednesdayStart
     *
     * @param \DateTime $wednesdayStart
     * @return VendorBusinessHours
     */
    public function setWednesdayStart($wednesdayStart)
    {
        $this->wednesdayStart = $wednesdayStart;

        return $this;
    }

    /**
     * Get wednesdayStart
     *
     * @return \DateTime 
     */
    public function getWednesdayStart()
    {
        return $this->wednesdayStart;
    }

    /**
     * Set wednesdayEnd
     *
     * @param \DateTime $wednesdayEnd
     * @return VendorBusinessHours
     */
    public function setWednesdayEnd($wednesdayEnd)
    {
        $this->wednesdayEnd = $wednesdayEnd;

        return $this;
    }

    /**
     * Get wednesdayEnd
     *
     * @return \DateTime 
     */
    public function getWednesdayEnd()
    {
        return $this->wednesdayEnd;
    }

    /**
     * Set thursdayStart
     *
     * @param \DateTime $thursdayStart
     * @return VendorBusinessHours
     */
    public function setThursdayStart($thursdayStart)
    {
        $this->thursdayStart = $thursdayStart;

        return $this;
    }

    /**
     * Get thursdayStart
     *
     * @return \DateTime 
     */
    public function getThursdayStart()
    {
        return $this->thursdayStart;
    }

    /**
     * Set thursdayEnd
     *
     * @param \DateTime $thursdayEnd
     * @return VendorBusinessHours
     */
    public function setThursdayEnd($thursdayEnd)
    {
        $this->thursdayEnd = $thursdayEnd;

        return $this;
    }

    /**
     * Get thursdayEnd
     *
     * @return \DateTime 
     */
    public function getThursdayEnd()
    {
        return $this->thursdayEnd;
    }

    /**
     * Set fridayStart
     *
     * @param \DateTime $fridayStart
     * @return VendorBusinessHours
     */
    public function setFridayStart($fridayStart)
    {
        $this->fridayStart = $fridayStart;

        return $this;
    }

    /**
     * Get fridayStart
     *
     * @return \DateTime 
     */
    public function getFridayStart()
    {
        return $this->fridayStart;
    }

    /**
     * Set fridayEnd
     *
     * @param \DateTime $fridayEnd
     * @return VendorBusinessHours
     */
    public function setFridayEnd($fridayEnd)
    {
        $this->fridayEnd = $fridayEnd;

        return $this;
    }

    /**
     * Get fridayEnd
     *
     * @return \DateTime 
     */
    public function getFridayEnd()
    {
        return $this->fridayEnd;
    }

    /**
     * Set saturdayStart
     *
     * @param \DateTime $saturdayStart
     * @return VendorBusinessHours
     */
    public function setSaturdayStart($saturdayStart)
    {
        $this->saturdayStart = $saturdayStart;

        return $this;
    }

    /**
     * Get saturdayStart
     *
     * @return \DateTime 
     */
    public function getSaturdayStart()
    {
        return $this->saturdayStart;
    }

    /**
     * Set saturdayEnd
     *
     * @param \DateTime $saturdayEnd
     * @return VendorBusinessHours
     */
    public function setSaturdayEnd($saturdayEnd)
    {
        $this->saturdayEnd = $saturdayEnd;

        return $this;
    }

    /**
     * Get saturdayEnd
     *
     * @return \DateTime 
     */
    public function getSaturdayEnd()
    {
        return $this->saturdayEnd;
    }

    /**
     * Set sundayStart
     *
     * @param \DateTime $sundayStart
     * @return VendorBusinessHours
     */
    public function setSundayStart($sundayStart)
    {
        $this->sundayStart = $sundayStart;

        return $this;
    }

    /**
     * Get sundayStart
     *
     * @return \DateTime 
     */
    public function getSundayStart()
    {
        return $this->sundayStart;
    }

    /**
     * Set sundayEnd
     *
     * @param \DateTime $sundayEnd
     * @return VendorBusinessHours
     */
    public function setSundayEnd($sundayEnd)
    {
        $this->sundayEnd = $sundayEnd;

        return $this;
    }

    /**
     * Get sundayEnd
     *
     * @return \DateTime 
     */
    public function getSundayEnd()
    {
        return $this->sundayEnd;
    }
}
