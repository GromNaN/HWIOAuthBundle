<?php

/*
 * This file is part of the HWIOAuthBundle package.
 *
 * (c) Hardware Info <opensource@hardware.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HWI\Bundle\OAuthBundle\Tests\OAuth\ResourceOwner;

use HWI\Bundle\OAuthBundle\OAuth\ResourceOwner\KeycloakResourceOwner;
use HWI\Bundle\OAuthBundle\Test\OAuth\ResourceOwner\GenericOAuth2ResourceOwnerTestCase;

final class KeycloakResourceOwnerTest extends GenericOAuth2ResourceOwnerTestCase
{
    protected array $options = [
      'base_url' => 'http://keycloak.example.com/auth',
      'realm' => 'example',
      'client_id' => 'clientid',
      'client_secret' => 'clientsecret',

      'authorization_url' => 'http://keycloak.example.com/auth/realms/example/protocol/openid-connect/auth',
      'access_token_url' => 'http://keycloak.example.com/auth/realms/example/protocol/openid-connect/token',
      'infos_url' => 'http://keycloak.example.com/auth/realms/example/protocol/openid-connect/userinfo',

      'attr_name' => 'access_token',
    ];

    protected string $authorizationUrlBasePart = 'http://keycloak.example.com/auth/realms/example/protocol/openid-connect/auth?response_type=code&client_id=clientid&scope=openid+email';
    protected string $redirectUrlPart = '&redirect_uri=http%3A%2F%2Fredirect.to%2F&approval_prompt=auto';
    protected array $authorizationUrlParams = ['approval_prompt' => 'auto'];

    protected string $resourceOwnerClass = KeycloakResourceOwner::class;

    public function testIdpHint(): void
    {
        $resourceOwner = $this->createResourceOwner(['idp_hint' => 'myhint']);

        $this->assertStringContainsString(
          'kc_idp_hint=myhint',
          $resourceOwner->getAuthorizationUrl('http://redirect.to/')
        );
    }
}
