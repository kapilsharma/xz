<?php
/**
 * Created by PhpStorm.
 * User: kapil
 * Date: 13/6/15
 * Time: 12:30 AM
 */

class Seeder {

    const CHARACTERS = 'abc def ghi jkl mn op qr st uv wx yz';

    /**
     * Return a Varchar of given size.
     *
     * @param int $size Number of characters in the returned data
     * @returns string $varchar
     */
    public function getVarchar($size)
    {
        $varchar = "";

        for ($i = 1; $i < $size; $i++) {
            $varchar .= $this->getRandomCharacter();
        }

        return ucfirst($varchar) . '.';
    }

    private function getRandomCharacter()
    {
        return substr(Seeder::CHARACTERS, mt_rand(0, 35), 1);
    }

}