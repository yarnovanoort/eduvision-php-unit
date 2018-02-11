<?php
namespace Phpunittest\Tests;

use Phpunittest\Http\Request;
use Phpunittest\Http\Response;
use Phpunittest\Validation\Validator;

class ValidatorTest extends \PHPUnit\Framework\TestCase
{
    protected $request;
    protected $response;
    protected $validator;
    protected $testdata;

    protected function setUpRequestResponse()
    {
        if($this->testdata == null) {
            $this->testdata = [];
        }

        $this->request = new Request($this->testdata);
        $this->response = new Response($this->request);
        $this->validator = new Validator($this->request, $this->response);

    }

    public function testGetIsValidReturnsTrue()
    {
        $this->setUpRequestResponse();
        $this->validator->setIsValid(true);

        $this->assertTrue($this->validator->getIsValid());
    }

    public function testGetIsValidReturnsFalse()
    {
        $this->setUpRequestResponse();
        $this->validator->setIsValid(false);

        $this->assertFalse($this->validator->getIsValid());

    }

    public function testCheckForMinStringLengthWithValidData()
    {
        $this->testdata = ['name' => 'Yarno'];
        $this->setUpRequestResponse();

        $errors = $this->validator->check(['name' => 'min:3']);

        $this->assertCount(0, $errors);
    }

    public function testCheckForMinStringLengthWithInValidData()
    {
        $this->testdata = ['name' => 'Ya'];
        $this->setUpRequestResponse();

        $errors = $this->validator->check(['name' => 'min:3']);

        $this->assertCount(1, $errors);
    }

    public function TestCheckForEmailWithValidData()
    {
        $this->testdata = ['email' => 'ik@yarnovanoort.nl'];
        $this->setUpRequestResponse();

        $errors = $this->validator->check(['email' => 'email']);

        $this->assertCount(0, $errors);
    }

    public function TestCheckForEmailWithInValidData()
    {
        $this->testdata = ['email' => 'ik'];
        $this->setUpRequestResponse();

        $errors = $this->validator->check(['email' => 'email']);

        $this->assertCount(1, $errors);
    }

    public function testValidateWithInvalidData()
    {
        $this->testdata = ['check_field' => 'x'];
        $this->setUpRequestResponse();
        $this->validator->validate(['check_field' => 'email'], '/register');
    }
}