<?php

namespace Jmf\CrudEngine\Tests\Routing;

use Jmf\CrudEngine\Configuration\ActionConfiguration;
use Jmf\CrudEngine\Configuration\KeyStringCollection;
use Jmf\CrudEngine\Configuration\RedirectionConfiguration;
use Jmf\CrudEngine\Configuration\RouteConfiguration;
use Jmf\CrudEngine\Configuration\ViewConfiguration;
use Jmf\CrudEngine\Routing\IndexActionRouteLoader;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Routing\RouteCollection;

class IndexActionRouteLoaderTest extends TestCase
{
    private IndexActionRouteLoader $loader;

    private RouteCollection $routeCollection;

    protected function setUp(): void
    {
        $this->loader = new IndexActionRouteLoader();

        $this->routeCollection = new RouteCollection();
    }

    public function testLoad(): void
    {
        $actionConfiguration = $this->givenActionConfiguration(
            entityClass: \stdClass::class,
            action:      'index',
            entityName:  'foo',
            routePath:   'foo/bar',
        );

        $this->loader->load($this->routeCollection, $actionConfiguration);

        $this->assertCount(1, $this->routeCollection->all());

        $route = $this->routeCollection->get('foo.index');

        $this->assertNotNull($route);
        $this->assertSame('/foo/bar', $route->getPath());
    }

    /**
     * @param class-string $entityClass
     */
    private function givenActionConfiguration(
        string $entityClass,
        string $action,
        ?string $entityName = null,
        string $redirectionRoute = '',
        ?string $routeName = null,
        string $routePath = '',
        string $viewPath = '',
    ): ActionConfiguration {
        $redirectionConfiguration = new RedirectionConfiguration(
            route:      $redirectionRoute,
            parameters: new KeyStringCollection([]),
        );

        $routeConfiguration = new RouteConfiguration(
            name:         $routeName,
            path:         $routePath,
            parameters:   new KeyStringCollection([]),
            requirements: new KeyStringCollection([]),
        );

        $viewConfiguration = new ViewConfiguration(
            path:      $viewPath,
            variables: new KeyStringCollection([]),
        );

        return new ActionConfiguration(
            entityClass:              $entityClass,
            action:                   $action,
            entityName:               $entityName,
            formTypeClass:            null,
            helperClass:              null,
            redirectionConfiguration: $redirectionConfiguration,
            routeConfiguration:       $routeConfiguration,
            viewConfiguration:        $viewConfiguration,
        );
    }
}
