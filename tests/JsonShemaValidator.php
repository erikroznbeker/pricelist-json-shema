<?php


namespace Tests;

use Opis\JsonSchema\{
    Validator,
    ValidationResult,
};

trait JsonShemaValidator
{
    protected static Validator $validator;
    protected static string $schema;

    public static function setUpBeforeClass(): void
    {
        ini_set('precision', 2);
        ini_set('serialize_precision', 2);

        parent::setUpBeforeClass();
        self::$validator = new Validator();
        self::$schema = file_get_contents(__DIR__.'/../schema.json');
    }

    public function validate($data):ValidationResult
    {
        /** @var ValidationResult $result */
        return self::$validator->validate($data, self::$schema);
    }
}
