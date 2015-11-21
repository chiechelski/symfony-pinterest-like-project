<?php
// src/PinterestLike/UserBundle/Entity/User.php

namespace PinterestLike\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * User
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser implements AdvancedUserInterface, \Serializable, \JsonSerializable
{
     #Role constants
    const ROLE_USER    = 'ROLE_USER';
    const ROLE_ADMIN   = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    protected $name;

    /**
     * @Assert\NotBlank(groups={"user","registration","relationship"})
     * @Assert\Regex(
     *      groups = {"user","registration","relationship"},
     *      pattern="/\d|@/",
     *      match=false,
     *      message="Please enter a real first name"
     * )
     * @Assert\Length(
     *      groups = {"user","registration","relationship"},
     *      min = "2",
     *      max = "64",
     *      minMessage = "Your first name must be at least {{ limit }} characters length",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters length"
     * )
     * @ORM\Column(name="first_name", type="string", length=64, nullable=true)
     */
    protected $firstName;

    /**
     * @Assert\NotBlank(groups={"user","registration","relationship"})
     * @Assert\Regex(
     *      groups = {"user","registration","relationship"},
     *      pattern="/\d|@/",
     *      match=false,
     *      message="Please enter a real last name"
     * )
     * @Assert\Length(
     *      groups = {"user","registration"},
     *      min = "2",
     *      max = "64",
     *      minMessage = "Your last name must be at least {{ limit }} characters length",
     *      maxMessage = "Your last name cannot be longer than {{ limit }} characters length"
     * )
     * @ORM\Column(name="last_name", type="string", length=64, nullable=true)
     */
    protected $lastName;

    /**
     * Plain password. Used for model validation and no persisted.
     * @var $plainPassword
     * @Assert\Length(min="5", minMessage="Passwords must be at least {{ limit }} characters long")
     */
    protected $plainPassword;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_of_birth", type="datetime", nullable=true)
     */
    protected $dateOfBirth;

    /**
     * m or f
     *
     * @Assert\NotBlank(groups={"user","registration"})
     * @ORM\Column(name="gender", type="string", length=1, nullable=true)
     */
    protected $gender;

    /**
     * @var \DateTime $created_at
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var \DateTime $registered_at
     *
     * @ORM\Column(name="registered_at", type="datetime", nullable=true)
     */
    protected $registeredAt;

    /**
     * vendor or user
     *
     * @Assert\NotBlank(groups={"user","registration"})
     * @ORM\Column(name="type", type="string", length=6, nullable=true)
     */
    protected $type;

    /**
     * vendor or user
     *
     * @Assert\NotBlank(groups={"user","registration"})
     * @ORM\Column(name="registration_step", type="string", length=5, nullable=true)
     */
    protected $registrationStep;

     /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;

    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;

    /** @ORM\Column(name="google_id", type="string", length=255, nullable=true) */
    protected $google_id;

    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $google_access_token;

    /** @ORM\Column(name="yahoo_id", type="string", length=255, nullable=true) */
    protected $yahoo_id;

    /** @ORM\Column(name="yahoo_access_token", type="string", length=1256, nullable=true) */
    protected $yahoo_access_token;

    public function __construct()
    {
        parent::__construct();
        // your own logic

        $this->isActive = true;

        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }


    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     * @return User
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
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

    /**
     * Set registeredAt
     *
     * @param \DateTime $registeredAt
     * @return User
     */
    public function setRegisteredAt($registeredAt)
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    /**
     * Get registeredAt
     *
     * @return \DateTime
     */
    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set registration step
     *
     * @param string $registrationStep
     * @return User
     */
    public function setRegistrationStep($registrationStep)
    {
        $this->registrationStep = $registrationStep;

        return $this;
    }

    /**
     * Get registration step
     *
     * @return string
     */
    public function getRegistrationStep()
    {
        return $this->registrationStep;
    }

    public function getName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return Boolean true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return Boolean true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return Boolean true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Set is_active status
     * NOTE: we shouldn't really use this directly any more. Use locked or deactivated instead
     *
     * @param boolean $isActive
     * @return User
     */
    private function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get is_active status
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @return \DateTime
     */
    public function getLockedAt()
    {
        return $this->lockedAt;
    }

    /**
     * Serializes the user.
     *
     * The serialized data have to contain the fields used by the equals method and the username.
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->firstName,
            $this->lastName,
            $this->roles,
            $this->email,
            $this->password,
            $this->salt,
            $this->id,
        ));
    }

    /**
     * Unserializes the user.
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        list(
            $this->firstName,
            $this->lastName,
            $this->roles,
            $this->email,
            $this->password,
            $this->salt,
            $this->id
            ) = $data;
    }

    /**
     * Don't put any sensitive information in here, like email address or confirmation code.
     *
     * @return array|mixed
     */
    public function jsonSerialize($includeExtra = true, $hideAddress = false)
    {
        $result = array(
            'id'          => $this->getId(),
            'first_name'  => $this->getFirstName(),
            'last_name'   => $this->getLastName(),
        );

        return $result;
    }

    /**
     * Returns the user roles
     *
     * @return array The roles
     */
    public function getRoles()
    {
        $roles = $this->roles;

        // we need to make sure to have at least one role
        $roles[] = static::ROLE_USER;

        return array_unique($roles);
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function eraseCredentials()
    {
        // Do nothing?
    }

    public function hasRole($role)
    {
        return in_array($role, $this->roles);
    }

    /**
     * Set social media ids
     * @param string $id
     * @return User
     */
    public function setFacebookId($id)
    {
        $this->facebook_id = $id;

        return $this;
    }

    public function setYahooId($id)
    {
        $this->yahoo_id = $id;

        return $this;
    }

    public function setGoogleId($id)
    {
        $this->google_id = $id;

        return $this;
    }

    /**
     * Set social media access
     * @param string $accessToken
     * @return User
     */
    public function setFacebookAccessToken($accessToken)
    {
        $this->facebook_access_token = $accessToken;

        return $this;
    }

    public function setYahooAccessToken($accessToken)
    {
        $this->yahoo_access_token = $accessToken;

        return $this;
    }

    public function setGoogleAccessToken($accessToken)
    {
        $this->google_access_token = $accessToken;

        return $this;
    }
}
