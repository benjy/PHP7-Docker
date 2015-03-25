<?php

/**
 * @file
 * Contains \Drupal\Tests\Core\Authentication\AuthenticationManagerTest.
 */

namespace Drupal\Tests\Core\Authentication;

use Drupal\Core\Authentication\AuthenticationManager;
use Drupal\Core\Authentication\AuthenticationProviderFilterInterface;
use Drupal\Core\Authentication\AuthenticationProviderInterface;
use Drupal\Tests\UnitTestCase;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;

/**
 * @coversDefaultClass \Drupal\Core\Authentication\AuthenticationManager
 * @group Authentication
 */
class AuthenticationManagerTest extends UnitTestCase {

  /**
   * @covers ::defaultFilter
   * @covers ::applyFilter
   *
   * @dataProvider providerTestDefaultFilter
   */
  public function testDefaultFilter($applies, $has_route, $auth_option, $provider_id, $global_providers = ['cookie' => TRUE]) {
    $authentication_manager = new AuthenticationManager($global_providers);
    $auth_provider = $this->getMock('Drupal\Core\Authentication\AuthenticationProviderInterface');
    $authentication_manager->addProvider($auth_provider, 'authentication.' . $provider_id);

    $request = new Request();
    if ($has_route) {
      $route = new Route('/example');
      if ($auth_option) {
        $route->setOption('_auth', $auth_option);
      }
      $request->attributes->set(RouteObjectInterface::ROUTE_OBJECT, $route);
    }

    $this->assertSame($applies, $authentication_manager->appliesToRoutedRequest($request, FALSE));
  }

  /**
   * @covers ::applyFilter
   */
  public function testApplyFilterWithFilterprovider() {
    $authentication_manager = new AuthenticationManager();
    $auth_provider = $this->getMock('Drupal\Tests\Core\Authentication\TestAuthenticationProviderInterface');
    $authentication_manager->addProvider($auth_provider, 'authentication.filtered');

    $auth_provider->expects($this->once())
      ->method('appliesToRoutedRequest')
      ->willReturn(TRUE);

    $request = new Request();
    $this->assertTrue($authentication_manager->appliesToRoutedRequest($request, FALSE));
  }

  /**
   * Provides data to self::testDefaultFilter().
   */
  public function providerTestDefaultFilter() {
    $data = [];
    // No route, cookie is global, should apply.
    $data[] = [TRUE, FALSE, [], 'cookie'];
    // No route, cookie is not global, should not apply.
    $data[] = [FALSE, FALSE, [], 'cookie', ['other' => TRUE]];
    // Route, no _auth, cookie is global, should apply.
    $data[] = [TRUE, TRUE, [], 'cookie'];
    // Route, no _auth, cookie is not global, should not apply.
    $data[] = [FALSE, TRUE, [], 'cookie', ['other' => TRUE]];
    // Route, with _auth and non-matching provider, should not apply.
    $data[] = [FALSE, TRUE, ['basic_auth'], 'cookie'];
    // Route, with _auth and matching provider should not apply.
    $data[] = [TRUE, TRUE, ['basic_auth'], 'basic_auth'];
    return $data;
  }

}

/**
 * Helper interface to mock two interfaces at once.
 */
interface TestAuthenticationProviderInterface extends AuthenticationProviderFilterInterface, AuthenticationProviderInterface {}
