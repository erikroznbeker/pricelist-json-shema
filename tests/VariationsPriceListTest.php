<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Opis\JsonSchema\{
    Validator,
    ValidationResult,
    Helper,
};

class VariationsPriceListTest extends TestCase
{
    use JsonShemaValidator;

    public function testVariationPriceList():void
    {
        $data = Helper::toJSON([
            [
                'group' => 'Pizza',
                'name' => 'Margherita',
                'variations' => [
                    [
                        'name' => 'Small',
                        'price' => 20.99,
                    ],
                    [
                        'name' => 'Medium',
                        'price' => 30.50,
                    ],
                ],
            ]
        ]);

        $result = $this->validate($data);
        $this->assertTrue($result->isValid());
    }

    public function testShouldFailIfHasPriceAndVariations():void
    {
        $data = Helper::toJSON([
            [
                'group' => 'Pizza',
                'name' => 'Margherita',
                'price' => 20.99,
                'variations' => [
                    [
                        'name' => 'Small',
                        'price' => 20.99,
                    ],
                    [
                        'name' => 'Medium',
                        'price' => 30.50,
                    ],
                ],
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testShoulfFailIfPriceAndVariationsAreMissing():void
    {

        $data = Helper::toJSON([
            [
                'group' => 'Pizza',
                'name' => 'Margherita',
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testShouldFailIfVariationNameIsMissing():void
    {
        $data = Helper::toJSON([
            [
                'group' => 'Pizza',
                'name' => 'Margherita',
                'variations' => [
                    [
                        'price' => 20.99,
                    ],
                ],
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testShouldFailIfVariationPriceIsMissing():void
    {
        $data = Helper::toJSON([
            [
                'group' => 'Pizza',
                'name' => 'Margherita',
                'variations' => [
                    [
                        'name' => 'Small',
                    ],
                ],
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testShouldFailIfVariationPriceIsNegative():void
    {
        $data = Helper::toJSON([
            [
                'name' => 'Margherita',
                'variations' => [
                    [
                        'name' => 'Small',
                        'price' => -20.99,
                    ],
                ],
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testShouldFailIfVariationPriceIsString():void
    {
        $data = Helper::toJSON([
            [
                'name' => 'Margherita',
                'variations' => [
                    [
                        'name' => 'Small',
                        'price' => '0',
                    ],
                ],
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testShouldFailIfVariationPriceHasMoreThan2Decimals():void
    {
        $data = Helper::toJSON([
            [
                'name' => 'Margherita',
                'variations' => [
                    [
                        'name' => 'Small',
                        'price' => 1.234,
                    ],
                ],
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testShouldFailIfVariationsAreEmpty()
    {
        $data = Helper::toJSON([
            [
                'name' => 'Margherita',
                'variations' => [],
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testShouldFailIfVariationsAreNotArray()
    {
        $data = Helper::toJSON([
            [
                'name' => 'Margherita',
                'variations' => 'not array',
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testShouldFailIfVariationsAreNotUnique()
    {
        $data = Helper::toJSON([
            [
                'name' => 'Margherita',
                'variations' => [
                    [
                        'name' => 'Small',
                        'price' => 10,
                    ],
                    [
                        'name' => 'Small',
                        'price' => 10,
                    ],
                ],
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testShouldFailIfVariationItemHasAdditionalProperties()
    {
        $data = Helper::toJSON([
            [
                'name' => 'Margherita',
                'variations' => [
                    [
                        'name' => 'Small',
                        'price' => 10,
                        'additional' => 'property',
                    ],
                ],
            ]
        ]);

        $result = $this->validate($data);
        $this->assertFalse($result->isValid());
    }
}
