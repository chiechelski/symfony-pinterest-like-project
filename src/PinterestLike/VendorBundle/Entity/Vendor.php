<?php

namespace PinterestLike\VendorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PinterestLike\CoreBundle\Library\UploadableImage;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vendor
 *
 * @ORM\Entity(repositoryClass="PinterestLike\VendorBundle\Entity\VendorRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="vendor")
 */
class Vendor extends UploadableImage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @ORM\OneToOne(targetEntity="PinterestLike\UserBundle\Entity\User", inversedBy="vendor")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @ORM\Column(name="name", type="string", length=64, nullable=true)
     */
    private $name;

    /**
     * @var File $logo
     *
     * @Assert\File(maxSize="15M")
     * @Assert\Image(
     *      mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/gif"
     *      }
     * )
     */
    protected $file;

    /**
     * @var string $logo
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    protected $logo;

    /**
     * @ORM\Column(name="contact_person", type="string", length=100, nullable=true)
     */
    private $contactPerson;

    /**
     * @ORM\Column(name="phone", type="string", length=32, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(name="mobile", type="string", length=32, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(name="address", type="string", length=256, nullable=true)
     */
    private $address;

    /**
     * @var string $state
     *
     * @ORM\Column(name="state", type="string", length=35, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=15, nullable=true)
     */
    private $postcode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=2)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=256, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=256, nullable=true)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="business_hours", type="string", length=250, nullable=true)
     */
    private $businessHours;

    /**
     * ORM\OneToOne(targetEntity="PinterestLike\VendorBundle\Entity\VendorBusinessHours", inversedBy="vendor")
     * ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)     *
     * protected $businessHours;
     */

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="social_media_links", type="text", nullable=true)
     */
    private $socialMediaLinks;

    /**
     * @ORM\OneToMany(targetEntity="VendorImage", mappedBy="vendor", cascade={"persist", "remove"})
     */
    protected $images;

    /**
     * @ORM\OneToMany(targetEntity="VendorVideo", mappedBy="vendor", cascade={"persist", "remove"})
     */
    protected $videos;

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
     * Set name
     *
     * @param string $name
     * @return Vendor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Vendor
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set phone
     *
     * @param string $phoneNumber
     * @return Vendor
     */
    public function setPhone($phoneNumber)
    {
        $this->phone = $phoneNumber;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return Vendor
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set mobile
     *
     * @param string $mobileNumber
     * @return Vendor
     */
    public function setMobile($mobileNumber)
    {
        $this->mobile = $mobileNumber;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set contact person
     *
     * @param string $contactPerson
     * @return Vendor
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;

        return $this;
    }

    /**
     * Get contact person
     *
     * @return string
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     * Set streetAddress
     *
     * @param string $streetAddress
     * @return Vendor
     */
    public function setAddress($streetAddress)
    {
        $this->address = $streetAddress;

        return $this;
    }

    /**
     * Get streetAddress
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Vendor
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Vendor
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Vendor
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set category
     *
     * @param string $businessCategory
     * @return Vendor
     */
    public function setCategory($businessCategory)
    {
        $this->category = $businessCategory;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set businessHours
     *
     * @param string $businessHours
     * @return Vendor
     */
    public function setBusinessHours($businessHours)
    {
        $this->businessHours = $businessHours;

        return $this;
    }

    /**
     * Get businessHours
     *
     * @return string
     */
    public function getBusinessHours()
    {
        return $this->businessHours;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Vendor
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set socialMediaLinks
     *
     * @param string $socialMediaLinks
     * @return Vendor
     */
    public function setSocialMediaLinks($socialMediaLinks)
    {
        $this->socialMediaLinks = $socialMediaLinks;

        return $this;
    }

    /**
     * Get socialMediaLinks
     *
     * @return string
     */
    public function getSocialMediaLinks()
    {
        return $this->socialMediaLinks;
    }

    /**
     * Set vendor
     *
     * @param \PinterestLike\UserBundle\Entity\User $vendor
     * @return User
     */
    public function setUser(\PinterestLike\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \PinterestLike\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get user name
     *
     * @return \PinterestLike\UserBundle\Entity\User
     */
    public function getUserName()
    {
        return $this->getUser()->getFullName();
    }

    /**
     * Add image
     *
     * @param VendorImage $image
     * @return Vendor
     */
    public function addImage($image)
    {
        if (!$image) {
            return $this;
        }
        $this->images->add($image);
        $image->setVendor($this);

        return $this;
    }

    /**
     * Remove images
     *
     * @param \PinterestLike\VendorBundle\Entity\VendorImage $images
     */
    public function removeImage(\PinterestLike\VendorBundle\Entity\VendorImage $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add video
     *
     * @param VendorVideo $video
     * @return Vendor
     */
    public function addVideo($video)
    {
        if (!$video) {
            return $this;
        }
        $this->videos->add($video);
        $video->setVendor($this);

        return $this;
    }

    /**
     * Remove videos
     *
     * @param \PinterestLike\VendorBundle\Entity\VendorVideos $video
     */
    public function removeVideo(\PinterestLike\VendorBundle\Entity\VendorVideo $video)
    {
        $this->videos->removeElement($video);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Get nbr of medias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNumberOfMedias()
    {
        return $this->videos->count() + $this->images->count() ;
    }




    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file) {
            return;
        }

        $this->logo = $this->generateNewFileName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        $this->doUpload('logo');
    }

    public function getUploadDir()
    {
        return 'images/vendor_logos';
    }

    public function getAbsolutePath()
    {
        return null === $this->logo ? null : $this->getUploadRootDir() . '/' . $this->logo;
    }

    public function getWebPath()
    {
        // perhaps it should return a path beginning with a slash?
        return null === $this->logo ? null : $this->getUploadDir() . '/' . $this->logo;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }
}
