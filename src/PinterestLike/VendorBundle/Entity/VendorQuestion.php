<?php

namespace PinterestLike\VendorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VendorQuestion
 *
 * @ORM\Table(name="vendor_question")
 * @ORM\Entity(repositoryClass="PinterestLike\VendorBundle\Entity\VendorQuestionRepository")
 */
class VendorQuestion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="PinterestLike\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="PinterestLike\VendorBundle\Entity\Vendor")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id", nullable=true)
     */
    private $vendor;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="blob")
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


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
     * Set user
     *
     * @param \stdClass $user
     * @return VendorQuestion
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set vendor
     *
     * @param \stdClass $vendor
     * @return VendorQuestion
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return \stdClass
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return VendorQuestion
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return VendorQuestion
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
