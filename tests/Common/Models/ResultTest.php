<?php

namespace Sportic\Omniresult\Common\Tests\Common\Models;

use Sportic\Omniresult\Common\Models\Result;
use Sportic\Omniresult\Common\Tests\AbstractTest;

/**
 * Class ResultTest
 * @package Sportic\Omniresult\Common\Tests\Common\Models
 */
class ResultTest extends AbstractTest
{

    /**
     * @dataProvider dataParseNamesFromFull
     * @param $fullName
     * @param $firstName
     * @param $lastName
     */
    public function testParseNamesFromFull($fullName, $firstName, $lastName)
    {
        $result = new Result();
        $result->setFullName($fullName);

        self::assertSame($firstName, $result->getFirstName());
        self::assertSame($lastName, $result->getLastName());
    }

    /**
     * @return array
     */
    public function dataParseNamesFromFull()
    {
        return [
            ['John Doe', 'John', 'Doe'],
            ['John Mike Doe', 'John Mike', 'Doe'],
            ['John, Mike Doe', 'John', 'Mike Doe'],
        ];
    }

    /**
     * @dataProvider dataParseFullName
     * @param $fullName
     * @param $firstName
     * @param $lastName
     */
    public function testParseFullName($fullName, $firstName, $lastName)
    {
        $result = new Result();
        $result->setFirstName($firstName);
        $result->setLastName($lastName);

        self::assertSame($fullName, $result->getFullName());
    }

    /**
     * @return array
     */
    public function dataParseFullName()
    {
        return [
            ['John', 'John', ''],
            ['John Doe', 'John', 'Doe'],
            ['John Mike Doe', 'John Mike', 'Doe'],
            ['John Mike Doe', 'John', 'Mike Doe'],
        ];
    }

    public function testToArrayWithEmptyResult()
    {
        $result = new Result();
        self::assertSame(
            [
                'id' => null,
                'posGen' => null,
                'posCategory' => null,
                'posGender' => null,
                'bib' => null,
                'fullName' => null,
                'firstName' => null,
                'lastName' => null,
                'time' => null,
                'timeGross' => null,
                'category' => null,
                'gender' => null,
                'country' => null,
                'club' => null,
                'status' => null,
                'notes' => null,
                'href' => null,
                'splits' => [],
                'parameters' => null,
            ],
            $result->toArray()
        );
    }


    /**
     * @dataProvider statusFromPositionData
     * @param $positionValue
     * @param $status
     */
    public function testStatusFromPosition($positionValue, $status)
    {
        foreach (['posGen', 'posCategory', 'posGender'] as $position) {
            $params = [$position => $positionValue];
            $result = new Result($params);
            self::assertSame($status, $result->getStatus());
        }
    }

    /**
     * @return array
     */
    public function statusFromPositionData()
    {
        return [
            ['dsq', 'disqualified'],
            ['DSQ', 'disqualified'],
            ['dns', 'dns'],
            ['DNS', 'dns'],
        ];
    }
}
