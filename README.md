<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Implementaciones por rama

El proyecto contiene dos implementaciones de la interfaz dinámica de Chirper:

### `master`: JavaScript y jQuery

La búsqueda se realiza con AJAX y actualiza la lista de chirps sin recargar la página. Las vistas Blade generan el HTML de los resultados.

Rutas principales:

| Método | Ruta | Función |
| --- | --- | --- |
| `GET` | `/` | Feed de chirps |
| `GET` | `/chirps/search` | Resultados dinámicos del feed |
| `GET` | `/user/{user}` | Perfil y chirps de un usuario |
| `GET` | `/user/{user}/chirps/search` | Búsqueda en el perfil |
| `GET` | `/chirps/{chirp}/edit` | Formulario tradicional para editar un chirp |

Las rutas para crear, actualizar y eliminar chirps también están definidas como rutas resource protegidas con autenticación.

### `feature/livewire`: Laravel Livewire

La búsqueda, la creación, la edición y la eliminación se manejan con componentes Livewire y enlaces `wire:*`; no se necesita escribir JavaScript ni jQuery propio para esas interacciones. Livewire sí carga y utiliza su runtime de JavaScript internamente.

Rutas de las páginas Livewire:

| Método | Ruta | Función |
| --- | --- | --- |
| `GET` | `/chirp/home` | Feed interactivo con búsqueda y creación de chirps |
| `GET` | `/chirp/{chirp}/edit` | Edición interactiva de un chirp; requiere autenticación |

En esta rama también siguen registradas las rutas tradicionales del feed, perfiles y operaciones resource. Por eso, la implementación Livewire del feed se visita en `/chirp/home`; la ruta `/` continúa usando el controlador tradicional. Los perfiles siguen usando sus rutas existentes.

Para cambiar entre implementaciones:

```bash
git switch master
git switch feature/livewire
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
