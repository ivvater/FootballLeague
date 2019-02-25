<?php

declare(strict_types=1);

namespace App\Response\Factory;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Scope;
use League\Fractal\TransformerAbstract;

class ResponseFactory
{
    /**
     * Make a scope object which will be able to transform either single Item or Collection
     *
     * @param $data
     * @param TransformerAbstract $transformer
     * @return Scope
     */
    public function make($data, TransformerAbstract $transformer): Scope
    {
        $manager = new Manager();
        $scope = ($data instanceof \Traversable || \is_array($data))
            ? new Collection($data, $transformer)
            : new Item($data, $transformer);

        return $manager->createData($scope);
    }
}
