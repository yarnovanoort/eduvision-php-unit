<?php
namespace Phpunittest\Tests;

use Phpunittest\Validation\Validator;
use Kunststube\CSRFP\SignatureGenerator;
use Dotenv;

class ValidatorTest extends \PHPUnit\Framework\TestCase
{
    protected $request;
    protected $response;
    protected $validator;
    protected $session;
    protected $blade;

    protected function setUp()
    {
        $signer = $this->getMockBuilder('Kunststube\CSRFP\SignatureGenerator')
            ->setConstructorArgs(['abc123'])
            ->getMock();

        $this->request = $this->getMockBuilder('Phpunittest\Http\Request')
            ->getMock();

        $this->session = $this->getMockBuilder('Phpunittest\Http\Session')
            ->getMock();

        $this->blade = $this->getMockBuilder('duncan3dc\Laravel\BladeInstance')
            ->setConstructorArgs(['abc', '123'])
            ->getMock();

        $this->response = $this->getMockBuilder('Phpunittest\Http\Response')
            ->setConstructorArgs([$this->request, $signer, $this->blade, $this->session])
            ->getMock();
    }

    public function testGetIsValidReturnsTrue()
    {
        $validator = new Validator($this->request, $this->response);
        $validator->setIsValid(true);

        $this->assertTrue($validator->getIsValid());
    }



    public function testGetIsValidReturnsFalse()
    {
        $validator = new Validator($this->request, $this->response);
        $validator->setIsValid(false);

        $this->assertFalse($validator->getIsValid());

    }

    public function testCheckForMinStringLengthWithValidData()
    {
        $req = $this->getMockBuilder('Phpunittest\Http\Request')
            ->getMock();

        $req->expects($this->once())
            ->method('input')
            ->will($this->returnValue('Yarno'));

        $validator = new Validator($req, $this->response);

        $errors = $validator->check(['name' => 'min:3']);

        $this->assertCount(0, $errors);
    }

    public function testCheckForMinStringLengthWithInValidData()
    {
        $req = $this->getMockBuilder('Phpunittest\Http\Request')
            ->getMock();

        $req->expects($this->once())
            ->method('input')
            ->will($this->returnValue('Ya'));

        $validator = new Validator($req, $this->response);

        $errors = $validator->check(['name' => 'min:3']);

        $this->assertCount(1, $errors);
    }

    public function TestCheckForEmailWithValidData()
    {
        $req = $this->getMockBuilder('Phpunittest\Http\Request')
            ->getMock();

        $req->expects($this->once())
            ->method('input')
            ->will($this->returnValue('ik@yarnovanoort.nl'));

        $validator = new Validator($req, $this->response);

        $errors = $validator->check(['email' => 'email']);

        $this->assertCount(0, $errors);
    }

    public function TestCheckForEmailWithInValidData()
    {
        $req = $this->getMockBuilder('Phpunittest\Http\Request')
            ->getMock();

        $req->expects($this->once())
            ->method('input')
            ->will($this->returnValue('ik'));

        $validator = new Validator($req, $this->response);

        $errors = $validator->check(['email' => 'email']);

        $this->assertCount(1, $errors);
    }

    public function testCheckForEqualToWithValidData()
    {
        $req = $this->getMockBuilder('Phpunittest\Http\Request')
            ->getMock();

        $req->expects($this->at(0))
            ->method('input')
            ->will($this->returnValue('Yarno'));

        $req->expects($this->at(1))
            ->method('input')
            ->will($this->returnValue('Yarno'));

        $validator = new Validator($req, $this->response, $this->session);

        $errors = $validator->check(['field_1' => 'equalTo:another_field']);

        $this->assertCount(0, $errors);
    }

    public function testCheckForEqualToWithInValidData()
    {
        $req = $this->getMockBuilder('Phpunittest\Http\Request')
            ->getMock();

        $req->expects($this->at(0))
            ->method('input')
            ->will($this->returnValue('Yarno'));

        $req->expects($this->at(1))
            ->method('input')
            ->will($this->returnValue('Yar'));

        $validator = new Validator($req, $this->response, $this->session);

        $errors = $validator->check(['field_1' => 'equalTo:another_field']);

        $this->assertCount(1, $errors);
    }

    public function testCheckForUniqueWithValidData()
    {
        $validator = $this->getMockBuilder('Phpunittest\Validation\Validator')
            ->setConstructorArgs([$this->request, $this->response, $this->session])
            ->setMethods(['getRows'])
            ->getMock();

        $validator->method('getRows')
            ->willReturn([]);

        $errors = $validator->check(['field' => 'unique:User']);
        $this->assertCount(0, $errors);
    }

    public function testCheckForUniqueWithInValidData()
    {
        $validator = $this->getMockBuilder('Phpunittest\Validation\Validator')
            ->setConstructorArgs([ $this->request, $this->response, $this->session])
            ->setMethods(['getRows'])
            ->getMock();

        $validator->method('getRows')
            ->willReturn(['a']);

        $errors = $validator->check(['field' => 'unique:User']);
        $this->assertCount(1, $errors);
    }

    public function testValidateWithValidData()
    {
        $validator = $this->getMockBuilder('Phpunittest\Validation\Validator')
            ->setConstructorArgs([$this->request, $this->response, $this->session])
            ->setMethods(['check'])
            ->getMock();

        $isValid = $validator->validate(['foo' => 'min:3'], '/register');
        $this->assertTrue($isValid);
    }
}