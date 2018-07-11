<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;
use App\Model\Meetup;
use App\Model\MeetupFull;

class SerializerController
{
    /**
     * Serialize in json.
     */
    public function serialize()
    {
        $serializer = new Serializer( // Le Serialiser
            [new PropertyNormalizer()], // On passe un tableau de normalizer(s).
            [new JsonEncoder()] // On passe un tableau d'encoder(s).
        );

        $meetup = new Meetup();
        $meetup->name = 'PHP Meetup 2018';

        var_dump($serializer->serialize($meetup, 'json'));
        die();
        // '{"name":"PHP Meetup 2018"}'
    }

    /**
     * Deserialize in json.
     */
    public function deserialize()
    {
        $serializer = new Serializer( // Le Serialiser
            [new PropertyNormalizer()], // On passe un tableau de normalizer(s).
            [new JsonEncoder()] // On passe un tableau d'encoder(s).
        );

        var_dump($serializer->deserialize(
            '{"name":"PHP Meetup 2018"}',
            Meetup::class,
            'json')
        );
        die();

        // object(App\Model\Meetup)[36]
        // public 'name' => string 'PHP Meetup 2018' (length=15)
    }

    /**
     * Serialize full in json.
     */
    public function serializeFull()
    {
        $serializer = new Serializer( // Le Serialiser
            [
                new DateTimeNormalizer(),
                new DataUriNormalizer(),
                new ObjectNormalizer(),
            ], // On passe un tableau de normalizer(s).
            [new JsonEncoder()] // On passe un tableau d'encoder(s).
        );

        $meetup = new MeetupFull();
        $meetup->id = 1;
        $meetup->name = 'PHP Meetup 2018';
        $meetup->date = new \DateTimeImmutable('2018/07/11');
        $meetup->logo = new \SplFileInfo('php-meetup.jpg');

        var_dump($serializer->serialize($meetup, 'json'));
        die();
        // '{"id":1,"name":"PHP Meetup 2018","date":"2018-07-11T00:00:00+02:00","logo":"data:image\/jpeg;base64,\/9j\/4AAQSkZJRgABAQAAAQABAAD\/4gKgSUNDX1BST0ZJTEUAAQEAAAKQbGNtcwQwAABtbnRyUkdCIFhZWiAH4gAHAAoACgAmADRhY3NwQVBQTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA9tYAAQAAAADTLWxjbXMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAtkZXNjAAABCAAAADhjcHJ0AAABQAAAAE53dHB0AAABkAAAABRjaGFkAAABpAAAACxyWFlaAAAB0AAAABRiWFlaAAAB5AAAABRnWFlaAAAB+AAAABRyVFJDAAACDAAAACBnVFJDAAACLAAAACBiVFJDAAACTAAAACBjaHJtAAACbAAAACRtbHVjA'... (length=6633)
    }

    /**
     * Update.
     */
    public function update()
    {
        $serializer = new Serializer( // Le Serialiser
            [
                new ObjectNormalizer(),
            ], // On passe un tableau de normalizer(s).
            [new JsonEncoder()] // On passe un tableau d'encoder(s).
        );

        $meetup = new MeetupFull();
        $meetup->id = 1;
        $meetup->name = 'PHP Meetup 2018';
        $meetup->date = new \DateTimeImmutable('2018/07/11');

        var_dump($serializer->deserialize(
            '{"id":1,"name":"PHP THE BEST"}',
            MeetupFull::class,
            'json',
            ['object_to_populate' => $meetup]));
        die();
        //object(App\Model\MeetupFull)[44]
        //public 'id' => int 1
        //public 'name' => string 'PHP THE BEST' (length=12)
        //public 'date' =>
        //object(DateTimeImmutable)[82]
        //  public 'date' => string '2018-07-11 00:00:00.000000' (length=26)
        //  public 'timezone_type' => int 3
        //  public 'timezone' => string 'Europe/Zurich' (length=13)
        //public 'logo' => null
    }

    /**
     * Export CSV.
     */
    public function exportCSV()
    {
        $serializer = new Serializer( // Le Serialiser
            [
                new ObjectNormalizer(),
            ], // On passe un tableau de normalizer(s).
            [new CsvEncoder()] // On passe un tableau d'encoder(s).
        );

        $data = [
            'foo' => 'aaa',
            'bar' => [
                ['id' => 111, 1 => 'bbb'],
                ['lorem' => 'ipsum'],
            ]
        ];

        $csv = $serializer->encode($data, 'csv');

        $response = new Response($csv);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8; application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="data.csv"');

        return $response;
    }

}