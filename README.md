<p align="center">
  <img src="logo.png" width="250" title="Logo" alt="Logo">
</p>

# About

Api Platform Doc Bundle is a Symfony bundle providing simple documentation linked to api platform if you don't want to use Swagger.

# Install

## Requirements

:warning: Here are the requirements for using Api Platform Doc Bundle:

```sh
php: >=7.4
api-platform/core: ^2.6
symfony/framework-bundle: >=5.4
```
## Get started

To get started with Api Platform Doc Bundle, use Composer to add the package to your project's dependencies:

```sh
composer require vtgianni/apiplatformdoc-bundle
```
Then add this service to your config/packages/security.yaml file:

```yaml
ApiPlatform\Core\Bridge\Symfony\Routing\RouteNameResolverInterface: '@api_platform.route_name_resolver.cached'
```
And this route to your config/routes.yaml file:

```yaml
api_platform_doc:
  resource: "@ApiPlatformDocBundle/Resources/config/routing.yaml"
```

Finally configure the desired route to view the documentation in .env.local file:

```bash
API_PLATFORM_DOC_PATH="documentation"
```

That's it! You should be able to see the documentation at this new route:

```bash
https://127.0.0.1:8000/documentation
```
