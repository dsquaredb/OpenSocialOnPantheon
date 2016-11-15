<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel;

use Symfony\Component\BrowserKit\Client as BaseClient;
use Symfony\Component\BrowserKit\Request as DomRequest;
use Symfony\Component\BrowserKit\Response as DomResponse;
<<<<<<< HEAD
=======
use Symfony\Component\BrowserKit\Cookie as DomCookie;
>>>>>>> web and vendor directory from composer install
use Symfony\Component\BrowserKit\History;
use Symfony\Component\BrowserKit\CookieJar;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Client simulates a browser and makes requests to a Kernel object.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
 *
 * @method Request|null  getRequest()  A Request instance
 * @method Response|null getResponse() A Response instance
=======
>>>>>>> web and vendor directory from composer install
 */
class Client extends BaseClient
{
    protected $kernel;
<<<<<<< HEAD
    private $catchExceptions = true;

    /**
=======

    /**
     * Constructor.
     *
>>>>>>> web and vendor directory from composer install
     * @param HttpKernelInterface $kernel    An HttpKernel instance
     * @param array               $server    The server parameters (equivalent of $_SERVER)
     * @param History             $history   A History instance to store the browser history
     * @param CookieJar           $cookieJar A CookieJar instance to store the cookies
     */
    public function __construct(HttpKernelInterface $kernel, array $server = array(), History $history = null, CookieJar $cookieJar = null)
    {
        // These class properties must be set before calling the parent constructor, as it may depend on it.
        $this->kernel = $kernel;
        $this->followRedirects = false;

        parent::__construct($server, $history, $cookieJar);
    }

    /**
<<<<<<< HEAD
     * Sets whether to catch exceptions when the kernel is handling a request.
     *
     * @param bool $catchExceptions Whether to catch exceptions
     */
    public function catchExceptions($catchExceptions)
    {
        $this->catchExceptions = $catchExceptions;
=======
     * {@inheritdoc}
     *
     * @return Request|null A Request instance
     */
    public function getRequest()
    {
        return parent::getRequest();
    }

    /**
     * {@inheritdoc}
     *
     * @return Response|null A Response instance
     */
    public function getResponse()
    {
        return parent::getResponse();
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Makes a request.
     *
<<<<<<< HEAD
=======
     * @param Request $request A Request instance
     *
>>>>>>> web and vendor directory from composer install
     * @return Response A Response instance
     */
    protected function doRequest($request)
    {
<<<<<<< HEAD
        $response = $this->kernel->handle($request, HttpKernelInterface::MASTER_REQUEST, $this->catchExceptions);
=======
        $response = $this->kernel->handle($request);
>>>>>>> web and vendor directory from composer install

        if ($this->kernel instanceof TerminableInterface) {
            $this->kernel->terminate($request, $response);
        }

        return $response;
    }

    /**
     * Returns the script to execute when the request must be insulated.
     *
<<<<<<< HEAD
=======
     * @param Request $request A Request instance
     *
>>>>>>> web and vendor directory from composer install
     * @return string
     */
    protected function getScript($request)
    {
        $kernel = str_replace("'", "\\'", serialize($this->kernel));
        $request = str_replace("'", "\\'", serialize($request));
<<<<<<< HEAD
        $errorReporting = error_reporting();

        $requires = '';
        foreach (get_declared_classes() as $class) {
            if (0 === strpos($class, 'ComposerAutoloaderInit')) {
                $r = new \ReflectionClass($class);
                $file = dirname(dirname($r->getFileName())).'/autoload.php';
                if (file_exists($file)) {
                    $requires .= "require_once '".str_replace("'", "\\'", $file)."';\n";
                }
            }
        }

        if (!$requires) {
            throw new \RuntimeException('Composer autoloader not found.');
        }
=======

        $r = new \ReflectionClass('\\Symfony\\Component\\ClassLoader\\ClassLoader');
        $requirePath = str_replace("'", "\\'", $r->getFileName());
        $symfonyPath = str_replace("'", "\\'", dirname(dirname(dirname(__DIR__))));
        $errorReporting = error_reporting();
>>>>>>> web and vendor directory from composer install

        $code = <<<EOF
<?php

error_reporting($errorReporting);

<<<<<<< HEAD
$requires
=======
require_once '$requirePath';

\$loader = new Symfony\Component\ClassLoader\ClassLoader();
\$loader->addPrefix('Symfony', '$symfonyPath');
\$loader->register();
>>>>>>> web and vendor directory from composer install

\$kernel = unserialize('$kernel');
\$request = unserialize('$request');
EOF;

        return $code.$this->getHandleScript();
    }

    protected function getHandleScript()
    {
        return <<<'EOF'
$response = $kernel->handle($request);

if ($kernel instanceof Symfony\Component\HttpKernel\TerminableInterface) {
    $kernel->terminate($request, $response);
}

echo serialize($response);
EOF;
    }

    /**
     * Converts the BrowserKit request to a HttpKernel request.
     *
<<<<<<< HEAD
=======
     * @param DomRequest $request A DomRequest instance
     *
>>>>>>> web and vendor directory from composer install
     * @return Request A Request instance
     */
    protected function filterRequest(DomRequest $request)
    {
        $httpRequest = Request::create($request->getUri(), $request->getMethod(), $request->getParameters(), $request->getCookies(), $request->getFiles(), $request->getServer(), $request->getContent());

        foreach ($this->filterFiles($httpRequest->files->all()) as $key => $value) {
            $httpRequest->files->set($key, $value);
        }

        return $httpRequest;
    }

    /**
     * Filters an array of files.
     *
     * This method created test instances of UploadedFile so that the move()
     * method can be called on those instances.
     *
     * If the size of a file is greater than the allowed size (from php.ini) then
     * an invalid UploadedFile is returned with an error set to UPLOAD_ERR_INI_SIZE.
     *
     * @see UploadedFile
     *
<<<<<<< HEAD
=======
     * @param array $files An array of files
     *
>>>>>>> web and vendor directory from composer install
     * @return array An array with all uploaded files marked as already moved
     */
    protected function filterFiles(array $files)
    {
        $filtered = array();
        foreach ($files as $key => $value) {
            if (is_array($value)) {
                $filtered[$key] = $this->filterFiles($value);
            } elseif ($value instanceof UploadedFile) {
                if ($value->isValid() && $value->getSize() > UploadedFile::getMaxFilesize()) {
                    $filtered[$key] = new UploadedFile(
                        '',
                        $value->getClientOriginalName(),
                        $value->getClientMimeType(),
                        0,
                        UPLOAD_ERR_INI_SIZE,
                        true
                    );
                } else {
                    $filtered[$key] = new UploadedFile(
                        $value->getPathname(),
                        $value->getClientOriginalName(),
                        $value->getClientMimeType(),
                        $value->getClientSize(),
                        $value->getError(),
                        true
                    );
                }
            }
        }

        return $filtered;
    }

    /**
     * Converts the HttpKernel response to a BrowserKit response.
     *
<<<<<<< HEAD
=======
     * @param Response $response A Response instance
     *
>>>>>>> web and vendor directory from composer install
     * @return DomResponse A DomResponse instance
     */
    protected function filterResponse($response)
    {
<<<<<<< HEAD
=======
        $headers = $response->headers->all();
        if ($response->headers->getCookies()) {
            $cookies = array();
            foreach ($response->headers->getCookies() as $cookie) {
                $cookies[] = new DomCookie($cookie->getName(), $cookie->getValue(), $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
            }
            $headers['Set-Cookie'] = $cookies;
        }

>>>>>>> web and vendor directory from composer install
        // this is needed to support StreamedResponse
        ob_start();
        $response->sendContent();
        $content = ob_get_clean();

<<<<<<< HEAD
        return new DomResponse($content, $response->getStatusCode(), $response->headers->all());
=======
        return new DomResponse($content, $response->getStatusCode(), $headers);
>>>>>>> web and vendor directory from composer install
    }
}
