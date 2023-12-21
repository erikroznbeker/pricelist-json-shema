<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Opis\JsonSchema\{
    Helper,
};

class SimplePriceListTest extends TestCase
{
    use JsonShemaValidator;

    public function testSimplePriceList(): void
    {

        $data = Helper::toJSON([
            [
                'group' => 'Hairstyle',
                'name' => 'Hair die and cut',
                'price' => 1,
            ]
        ]);

        $result = $this->validate($data);
        $this->assertTrue($result->isValid());
    }

    public function testSimplePriceListWithoutGroup(): void
    {

        $data = Helper::toJSON([
            [
                'name' => 'Pedicure',
                'price' => 99,
            ]
        ]);

        $result = $this->validate($data);
        $this->assertTrue($result->isValid());
    }

    public function testSimplePriceListMultipleItems(): void
    {
        $data = Helper::toJSON([
            [
                'group' => 'Manicure',
                'name' => 'Manicure with gel',
                'price' => 13,
            ],
            [
                'group' => 'Manicure',
                'name' => 'Manicure with gel and nail polish',
                'price' => 14,
            ],
            [
                'group' => 'Pedicure',
                'name' => 'Pedicure with gel',
                'price' => 15,
            ]
        ]);

        $result = $this->validate($data);
        $this->assertTrue($result->isValid());
    }

    public function testShouldPassWithValidPriceFormat()
    {
        $data = Helper::toJSON([
            [
                'name' => 'Polenta',
                'price' => 0,
            ],
            [
                'name' => 'Spaghetti Bolognese',
                'price' => 1,
            ],
            [
                'name' => 'Penne Arrabiata',
                'price' => 12.34,
            ],
            [
                'name' => 'Penne Carbonara',
                'price' => 5678.9,
            ],
            [
                'name' => 'Tagliatelle al ragu',
                'price' => 5.60,
            ],
        ]);
        $result = $this->validate($data);
        $this->assertTrue($result->isValid());
    }

    public function testShouldFailWithInvalidPriceFormat()
    {
        $data = Helper::toJSON([
            [
                'name' => 'Spaghetti Bolognese',
                'price' => '1',
            ],
        ]);
        $result = $this->validate($data);
        $this->assertFalse($result->isValid());

        $data = Helper::toJSON([
            [
                'name' => 'Pizza Margherita',
                'price' => -1,
            ],
        ]);
        $result = $this->validate($data);
        $this->assertFalse($result->isValid());

        $data = Helper::toJSON([
            [
                'name' => 'Calzone',
                'price' => 1.234,
            ],
        ]);
        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testShouldFailIfNameIsMissing(): void
    {
        $data = Helper::toJSON([
            [
                'group' => 'Manicure',
                'price' => 13,
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());

        $data = Helper::toJSON([
            [
                'price' => 16,
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }


    public function testShouldFailIfPriceIsMissing(): void
    {
        $data = Helper::toJSON([
            [
                'group' => 'Manicure',
                'name' => 'Manicure with gel',
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());


        $data = Helper::toJSON([
            [
                'name' => 'Manicure with gel',
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testShouldFailIfDataHasAdditionalProperties(): void
    {
        $data = Helper::toJSON([
            [
                'group' => 'Manicure',
                'name' => 'Manicure with gel',
                'price' => 13,
                'additional' => 'property',
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }
}
