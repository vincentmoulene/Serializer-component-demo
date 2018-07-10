<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use App\Model\Meetup;

class SerializerController
{
    public function test()
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    public function serialize()
    {
        $serializer = new Serializer(
            [new PropertyNormalizer()],
            [new JsonEncoder()]
        );

        $meetup = new Meetup();
        $meetup->name = 'PHP Meetup 2018';

        var_dump($serializer->serialize($meetup, 'json'));
        die();
    }
}