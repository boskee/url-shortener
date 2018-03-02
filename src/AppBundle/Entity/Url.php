<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Url
 *
 * @ORM\Table(name="url")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UrlRepository")
 */
class Url
{
    const HASH_CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\Url()
     * @Assert\NotBlank()
     * @ORM\Column(name="fullUrl", type="string", length=255, unique=true)
     */
    private $fullUrl = '';


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
     * Set fullUrl
     *
     * @param string $fullUrl
     * @return Url
     */
    public function setFullUrl($fullUrl)
    {
        $this->fullUrl = $fullUrl;

        return $this;
    }

    /**
     * Get fullUrl
     *
     * @return string 
     */
    public function getFullUrl()
    {
        return $this->fullUrl;
    }

    /**
     * @return string
     */
    function getHash()
    {
        $length = strlen(self::HASH_CHARACTERS);
        $id = $this->getId();
        $hash = '';
        while ($id > $length - 1)
        {
            $hash = self::HASH_CHARACTERS[(int)fmod($id, $length)] . $hash;
            $id = floor($id / $length);
        }
        return self::HASH_CHARACTERS[$id] . $hash;
    }

    public function __toString()
    {
        return $this->getFullUrl();
    }
}
