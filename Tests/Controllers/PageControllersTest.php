<?php
namespace Phpunittest\Tests;

use Phpunittest\Validation\Validator;
use Kunststube\CSRFP\SignatureGenerator;
use Dotenv;

class PageControllersTest extends \PHPUnit\Framework\TestCase
{
    protected $request;
    protected $response;
    protected $validator;
    protected $session;
    protected $blade;
    protected $signer;

    protected function setUp()
    {
        $this->signer = $this->getMockBuilder('Kunststube\CSRFP\SignatureGenerator')
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
            ->setConstructorArgs([$this->request, $this->signer, $this->blade, $this->session])
            ->getMock();
    }

    /**
     * @param $original
     * @param $expected
     *
     * @dataProvider providerTestMakeSlug
     */
    public function testMakeSlug($original, $expected)
    {
        $controller = $this->getMockBuilder('Phpunittest\Controllers\PageController')
            ->setConstructorArgs([$this->request, $this->response, $this->session,
                $this->signer, $this->blade])
            ->setMethods(null)
            ->getMock();

        $actual = $controller->makeSlug($original);

        $this->assertEquals($expected, $actual);
    }

    public function providerTestMakeSlug()
    {
        return [
            ["Hello World", "hello-world"],
            ["Goodbye, cruel world!", "goodbye-cruel-world"],
            ["What about an & and a ?", "what-about-an-and-a"],
            ["It should also handle é", "it-should-also-handle-e"]
        ];
    }

}