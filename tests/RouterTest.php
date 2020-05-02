<?php


namespace RoutingTest;


use PHPUnit\Framework\TestCase;
use Routing\Router;

final class RouterTest extends TestCase
{
    /** @var Router */
    private $router;

    /** @var string */
    private $uri;

    public function tearDown() : void
    {
        parent::tearDown();
        $this->router = null;
        $this->uri = null;
    }

    /** @test */
    public function ShouldCreateRouterObject()
    {
        $arrayUrls = array(
            "/get/{id}"
        );
        $router = Router::create($arrayUrls);
        $this->assertInstanceOf(Router::class, $router);
    }

    /** @test */
    public function ShouldDontCreateRouterObject()
    {
        $arrayUrls = array();
        $router = Router::create($arrayUrls);
        $this->assertNull($router);
    }

    /** @test */
    public function ShouldBeMatch(){
        $arrayUrls = array(
            "/get/{id}",
            "/post/{id}/{name}",
            "/put/{id}",
            "/delete/{id}",
            "/post/{name}",
            "/put/{name}",
            "/delete/{name}",
            "/delete/{id}",
            "/get/{name}/{id}",
            "/get/{id}/{id}",
        );
        $router = Router::create($arrayUrls);
        $match = $router->match("/get/120");
        $this->assertTrue($match->status);
    }

    /** @test */
    public function ShouldBeDontMatch(){
        $arrayUrls = array(
            "/get/{id}",
            "/post/{id}/{name}",
            "/put/{id}",
            "/delete/{id}",
            "/post/{name}",
            "/put/{name}",
            "/delete/{name}",
            "/delete/{id}",
            "/get/{name}/{id}",
            "/get/{id}/{id}",
        );
        $router = Router::create($arrayUrls);
        $match = $router->match("/test/120");
        $this->assertNotTrue($match->status);
    }

    /** @test */
    public function ShouldReturnUriMatch(){
        $arrayUrls = array(
            "/get/{id}",
            "/post/{id}/{name}",
            "/put/{id}",
            "/delete/{id}",
            "/post/{name}",
            "/put/{name}",
            "/delete/{name}",
            "/delete/{id}",
            "/get/{name}/{id}",
            "/get/{id}/{id}",
        );
        $router = Router::create($arrayUrls);
        $match = $router->match("/get/javier/100");
        $this->assertSame("/get/{name}/{id}",$match->uri);
    }

    /** @test */
    public function ShouldReturnIdUriMatch(){
        $arrayUrls = array(
            "/get/{id}",
            "/post/{id}/{name}",
            "/put/{id}",
            "/delete/{id}",
            "/get/{id}/{id}",
        );
        $router = Router::create($arrayUrls);
        $match = $router->match("/post/400/camilo");
        $this->assertSame(1,$match->id);
    }

    /** @test */
    public function ShouldReturnDifferentIdUriMatch(){
        $arrayUrls = array(
            "/get/{id}",
            "/post/{id}/{name}",
            "/put/{id}",
            "/delete/{id}",
            "/get/{id}/{id}",
        );
        $router = Router::create($arrayUrls);
        $match = $router->match("/put/400");
        $this->assertNotSame(5,$match->id);
    }

}