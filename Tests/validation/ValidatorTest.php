<?php
namespace Phpunittest\Tests;

use Phpunittest\Http\Request;
use Phpunittest\Http\Response;
use Phpunittest\Validation\Validator;

class ValidatorTest extends \PHPUnit\Framework\TestCase
{

    public function testGetIsValidReturnsTrue()
    {
        $request = new Request([]);
        $response = new Response($request);

        $validator = new Validator($request, $response);

        $validator->setIsValid(true);

        $this->assertTrue($validator->getIsValid());

    }

    public function testGetIsValidReturnsFalse()
{
    $request = new Request([]);
    $response = new Response($request);

    $validator = new Validator($request, $response);

    $validator->setIsValid(false);

    $this->assertFalse($validator->getIsValid());

}
}