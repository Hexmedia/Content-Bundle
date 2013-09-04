<?php
/**
 * Created by JetBrains PhpStorm.
 * User: krun
 * Date: 04.09.13
 * Time: 12:27
 * To change this template use File | Settings | File Templates.
 */

namespace Hexmedia\ContentBundle\Service;


use Hexmedia\ContentBundle\Repository\Doctrine\AreaRepository;

class Area {
    /**
     * @var AreaRepository
     */
    private $repository;
    private $session;

    /**
     * @param AreaRepository $repository
     */
    public function __construct(AreaRepository $repository, $session) {
        $this->repository = $repository;
        $this->session = $session;

        var_dump($session);
    }

    /**
     * Returns area content based on
     *
     * @param string $name
     * @param bool   $isGlobal
     * @param string $locale
     */
    public function get($name, $isGlobal, $locale = "") {

    }

    /**
     * Returns current page cache, based on route and parameters.
     *
     * @return string
     */
    private function getCurrentHash() {
       return "aaa";
    }



}