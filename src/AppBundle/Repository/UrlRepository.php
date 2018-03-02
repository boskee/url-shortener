<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Url;

/**
 * UrlRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UrlRepository extends EntityRepository
{
    /**
     * @param string $hash
     * @return bool|float|int
     */
    function findOneByHash($hash)
    {
        $length = strlen(Url::HASH_CHARACTERS);
        $size = strlen($hash) - 1;
        $string = str_split($hash);
        $out = strpos(Url::HASH_CHARACTERS, array_pop($string));
        foreach ($string as $i => $char) {
            $out += strpos(Url::HASH_CHARACTERS, $char) * pow($length, $size - $i);
        }
        return $this->findOneById($out);
    }
}