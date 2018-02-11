<?php
namespace Phpunittest\Controllers;

use Phpunittest\Interfaces\ControllerInterface;
use duncan3dc\Laravel\BladeInstance;
use Kunststube\CSRFP\SignatureGenerator;
use Phpunittest\Http\Response;
use Phpunittest\Http\Request;
use Phpunittest\Http\Session;

/**
 * Class BaseController
 * @package Phpunittest\Controllers
 */
class BaseController implements ControllerInterface {

    /**
     * @var BladeInstance
     */
    protected $blade;

    /**
     * @var SignatureGenerator
     */
    protected $signer;

    /**
     * @var Response
     */
    public $response;

    /**
     * @var Request
     */
    public $request;


    /**
     * @param string $type
     */
    public function __construct($type = "text/html")
    {
        $this->signer = new SignatureGenerator(getenv('CSRF_SECRET'));
        $this->blade = new BladeInstance(getenv('VIEWS_DIRECTORY'), getenv('CACHE_DIRECTORY'));
        $this->request = new Request($_REQUEST, $_GET, $_POST);
        $this->response = new Response($this->request);
        $this->session = new Session();
    }

}
