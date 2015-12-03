<?php

namespace PinterestLike\VendorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PinterestLike\CoreBundle\Library\UploadableImage;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * VendorVideo
 *
 * @ORM\Table(name="vendor_video")
 * @ORM\Entity(repositoryClass="PinterestLike\VendorBundle\Entity\VendorVideoRepository")
 */
class VendorVideo extends UploadableImage implements \JsonSerializable
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
     * @ORM\ManyToOne(targetEntity="PinterestLike\VendorBundle\Entity\Vendor", inversedBy="videos")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id", nullable=false)
     */
    private $vendor;

    /**
     * @var File $file
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="image_path", type="string", length=255)
     */
    protected $imagePath;

    /**
     * @var string
     *
     * @ORM\Column(name="video_url", type="string", length=512)
     */
    protected $videoUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="video_type", type="string", length=10)
     */
    protected $videoType;

    /**
     * @var string
     *
     * @ORM\Column(name="video_id", type="string", length=50)
     */
    protected $videoId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="PinterestLike\VendorBundle\Entity\Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    protected $category;

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
     * Set vendor
     *
     * @param $vendor
     * @return VendorVideo
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return Vendor
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set file
     *
     * @param string $file
     * @return VendorVideo
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return VendorVideo
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
     * Set imagePath
     *
     * @param string $imagePath
     * @return VendorVideo
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set videoUrl
     *
     * @param string $videoUrl
     * @return VendorVideo
     */
    public function setVideoUrl($videoUrl)
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    /**
     * Get videoUrl
     *
     * @return string
     */
    public function getVideoUrl()
    {
        return $this->videoUrl;
    }

    /**
     * Set videoType
     *
     * @param string $videoType
     * @return VendorVideo
     */
    public function setVideoType($videoType)
    {
        $this->videoType = $videoType;

        return $this;
    }

    /**
     * Get videoType
     *
     * @return string
     */
    public function getVideoType()
    {
        return $this->videoType;
    }

    /**
     * Set videoId
     *
     * @param string $videoId
     * @return VendorVideo
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * Get videoId
     *
     * @return string
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return VendorVideo
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        $this->setUpdatedAt($createdAt);

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

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return VendorVideo
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return VendorVideo
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
     * Set category
     *
     * @param $category
     * @return VendorVideo
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
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

        $this->imagePath = $this->generateNewFileName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        $this->doUpload('imagePath');
    }

    public function getUploadDir()
    {
        return 'images/vendor_videos';
    }

    public function getAbsolutePath()
    {
        return null === $this->imagePath ? null : $this->getUploadRootDir() . '/' . $this->imagePath;
    }

    public function getWebPath()
    {
        // perhaps it should return a path beginning with a slash?
        return null === $this->imagePath ? null : $this->getUploadDir() . '/' . $this->imagePath;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    public function jsonSerialize()
    {
        return array('url' => $this->getWebPath());
    }
}
