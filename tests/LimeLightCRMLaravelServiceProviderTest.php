<?php


namespace KevinEm\LimeLightCRMLaravel\Tests;


use ArrayAccess;
use Closure;
use KevinEm\AdobeSignLaravel\AdobeSignLaravelServiceProvider;
use KevinEm\AdobeSignLaravel\Facades\AdobeSignLaravel;
use KevinEm\LimeLightCRMLaravel\Facades\LimeLightCRMLaravel;
use KevinEm\LimeLightCRMLaravel\LimeLightCRMLaravelServiceProvider;
use Mockery as m;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

class LimeLightCRMLaravelServiceProviderTest extends TestCase
{
    /**
     * @var MockInterface
     */
    protected $app;

    /**
     * @var MockInterface
     */
    protected $config;

    /**
     * @var LimeLightCRMLaravelServiceProvider
     */
    protected $provider;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->config = m::mock(ArrayAccess::class);

        $this->app = m::mock(ArrayAccess::class);
        $this->app->shouldReceive('offsetGet')->zeroOrMoreTimes()->with('path.config')->andReturn('/some/config/path');
        $this->app->shouldReceive('offsetGet')->zeroOrMoreTimes()->with('config')->andReturn($this->config);

        $this->provider = new LimeLightCRMLaravelServiceProvider($this->app);
    }

    public function testBoot()
    {
        $this->provider->boot();
    }

    public function testRegister()
    {
        $this->config->shouldReceive('get')->withAnyArgs()->once()->andReturn([]);
        $this->config->shouldReceive('set')->withAnyArgs()->once()->andReturnUndefined();
        $this->app->shouldReceive('bind')->withAnyArgs()->twice()->andReturnUndefined();
        $this->config->shouldReceive('offsetGet')->zeroOrMoreTimes()->with('adobe-sign')->andReturn([]);

        $this->provider->register();
    }

    public function testFacade()
    {
        $facade = new LimeLightCRMLaravel();
        $facade->shouldReceive();
    }

    public function testCreateLimeLightCRMLaravelClosure()
    {
        $method = self::getMethod('createLimeLightCRMLaravelClosure');

        $app = [
            'config' => $this->config
        ];

        $this->config->shouldReceive('offsetGet')->with('lime-light-crm')->andReturn([
            'base_url' => 'mock_url',
            'username' => 'mock_username',
            'password' => 'mock_password'
        ]);

        $closure = $method->invokeArgs($this->provider, []);

        $this->assertInstanceOf(Closure::class, $closure);
        $this->assertNotNull($closure($app));
    }

    /**
     * @param string $name
     *
     * @return ReflectionMethod
     */
    protected static function getMethod($name)
    {
        $class = new ReflectionClass(LimeLightCRMLaravelServiceProvider::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }
}