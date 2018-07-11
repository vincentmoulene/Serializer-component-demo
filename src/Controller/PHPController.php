<?php

namespace App\Controller;

use App\Model\Meetup;

class PHPController
{
    /**
     * Serialize with php function.
     */
    public function serialize()
    {
        $meetup = new Meetup();
        $meetup->name = 'PHP Meetup 2018';

        var_dump(serialize($meetup));
        die();
        // 'O:16:"App\Model\Meetup":1:{s:4:"name";s:15:"PHP Meetup 2018";}'
    }

    /**
     * Deserialize with php function (eventually).
     */
    public function deserialize()
    {
        var_dump(unserialize('O:16:"App\Model\Meetup":1:{s:4:"name";s:15:"PHP Meetup 2018";}'));
        die();

        // object(App\Model\Meetup)[77]
        // public 'name' => string 'PHP Meetup 2018' (length=15)
    }

    /**
     * jsonEncode with php function (eventually).
     */
    public function jsonEncode()
    {
        $meetup = new Meetup();
        $meetup->name = 'PHP Meetup 2018';

        var_dump(json_encode($meetup));
        die();
        // '{"name":"PHP Meetup 2018"}'
    }

    /**
     * jsonDecode with php function.
     */
    public function jsonDecode()
    {
        var_dump(json_decode('{"name":"PHP Meetup 2018"}'));
        die();

        // object(stdClass)[77]
        // public 'name' => string 'PHP Meetup 2018' (length=15)
    }

}