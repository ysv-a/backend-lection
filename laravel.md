# CMS (Content management system), Framework

## CMS - для типовых проектов и прототипов, создание сайтов на готовом движке

- Wordpress
- Joomla
- Drupal
- OctoberCms(WinterCms)

Ecommerce:

- Magento
- OpenCart
- Shopify
- 1C-Битрикс
- Wordpress - Woocommerce
- PrestaShop

## Framework

Framework - для программирования, есть готовый каркас, на который мы пишем свою логику, т.е программирование не с нуля, а с середины

**Компонентные:**

- Laravel
- Symfony

**Монолитные:**

- Yii2
- Django

**Микрофреймворки:**

- Silex
- Slim
- Flask

Минимальный набор который нужен для работы, например для api, маршрутизатор - роутинг контроллер - собираем через компоненты под свои задачи

- премущество в скорости
- минусы - настройки всего в ручную


## Laravel

**Плюсы:**

- компонентный, компоненты можно доустанавливать, удалять
- архитектура написана по чистому коду, принципы Solid, grasp
- Rad \ Enterpise - разные подход к написаню
(Быстрая разработка приложений (RAD) — это модель разработки, в которой приоритет отдается быстрому прототипированию и быстрой обратной связи, а не длительным циклам разработки и тестирования.)
- ООП
- PSR совместимость - PHP Standards Recommendations
- следование паттернам
- современные инструменты
- мощный DIC - контейнер
- отвязка от фронтенда
- совместимость с php
- сообщество

**Минусы:**

- платная экосистема
- единоличная разработка
- устаревание документации и компонентов, т.к бысто обновляется

## Подходы

Фреймворкозависимый подход - используем все возможности фреймворка

Фреймворконезависимый подход - минимально использование логики фреймворка, чтоб можно было в буд. подключить написанную логику в др. приложения


# MVC - Model-View-Template (MVT)

![alt](/images/2d730bc4db5c7aab47a97c1b1d9ade4d.png)


# Artisan и django-admin (managy.py) - CLI

Artisan и django-admin - это интерфейс командной строки (CLI) . Он предоставляет ряд команд, которые будут полезны при разработке приложения.


## Artisan

php artisan list

php artisan make:model Author

php artisan make:model Author -m

-m - вместе с моделью создать миграцию
-с - вместе с моделью создать контроллер
-r - вместе с моделью создать ресурс. контроллер

php artisan make:model Author -mr

php artisan make:migration create_authors_table

php artisan make:controller AuthorController

https://laravel.su/docs/10.x/eloquent

https://laravel.su/docs/10.x/migrations

https://laravel.com/docs/10.x/starter-kits

https://marketplace.visualstudio.com/items?itemName=amirmarmul.laravel-blade-vscode

## django-admin

django-admin - это утилита командной строки Django для выполнения административных задач.

manage.py: утилита, позволяющая взаимодействовать с проектом различными способами.

django-admin startproject example_project - создание проекта

py manage.py startapp books - создание приложения

python manage.py runserver - запуска сервера

Приложение - это веб-приложение, которое что-то делает - например, система блогов, база данных публичных записей или небольшое приложение для проведения опросов.

Проект - это набор конфигураций и приложений для определенного веб-сайта. Проект может содержать несколько приложений. Приложение может находиться в нескольких проектах.

python -c "import secrets; print(secrets.token_urlsafe(38))"

# .env - переменные окружения

это централизованное хранилище настроек

# composer.json  — менеджер пакетов для PHP.

require какие пакеты нужно подключать всегда

require-dev - девелоперские пакеты, т.е подключать пакеты только в среде разработки

При указании допустимых версий пакетов можно использовать:

-точное соответствие (1.2.3)
-диапазоны с операторами сравнения (<1.2.3)
-комбинации этих операторов (>1.2.3 <1.3)
-последняя доступная (1.2.*)
-символ тильды (~1.2.3)
-знак вставки (^1.2.3)

1.2.3

**SemVer**

3 - Patch - увеличивается при исправлении ошибок с обеспечением обратной совместимости

2 - minor - увеличивается при добавлении функциональных возможностей с обеспечением обратной совместимости

1 - major - увеличивается при внесении изменений, приводящих к несовместимости


Указание тильды (~1.2.3) будет включать в себя все версии до 1.3 (не включительно), так как в семантическом версионировании это является моментом внедрения новых функциональных возможностей.

В данном случае будет получена последняя из стабильных минорных версий. Т.е. будет меняться только последняя цифра — 1.2.5, 1.2.8 и тд.

Указание знака вставки (^1.2.3) буквально означает "опасаться только критических изменений" и будет включать в себя версии вплоть до 2.0. Применительно к семантическому версионированию, изменение мажорной версии является моментом внесения в проект критических изменений, так что версии 1.3, 1.4 и 1.9 подходят, в то время как 2.0 — уже нет, т.е. не меняется только первая цифра.

Файл composer.lock сохраняет текущий список установленных зависимостей и их версии. Таким образом, на момент, когда версии зависимостей уже будут обновлены (команда update), другие люди, которые будут клонировать ваш проект, получат те же самые версии. Это позволяет убедиться в том, что каждый, кто получает ваш проект, имеет пакетное окружение, идентичное тому, которое вы использовали при разработке, и помогает избежать ошибок, которые могли бы возникнуть из-за обновления версий.

При каждом выполнении команды update версии обновлённый пакетов прописываются в composer.lock. Этот файл загоняется под систему контроля версий и при установке пакетов на новом сервере поставятся именно те версии пакетов, которые прописаны в этом файле. При выполнении команды install composer будет в первую очередь опираться на composer.lock. Таким образом на разных серверах будет гарантированно установлено одинаковое пакетное окружение с точки зрения версий.

**Команда composer install делает следующее:**

- Проверяет существует ли composer.lock:
— если нет, резолвит зависимости и создаёт его
— если composer.lock существует, устанавливает версии, указанные в нём


**Команда composer update:**

— Проверяет composer.json
— Определяет последние версии на основе указанных в этом файле
— Устанавливает последние версии
— Обновляет composer.lock в соответствии с установленными

В каталоге app находятся классы Laravel-приложения. По умолчанию, этот каталог имеет неймспейс App и классы в нём автозагружаются согласно стандарту PSR-4 (PSR-4 — Autoloading Standard)

# poetry и pip

pip freeze

pip freeze > requirements.txt

pip install -r requirements.txt

poetry: https://habr.com/ru/articles/593529/


# Middlewares

Посредники предоставляют удобный механизм для фильтрации HTTP запросов вашего приложения. Например, в Laravel есть посредник для проверки аутентификации пользователя. Если пользователь не аутентифицирован, посредник перенаправит его на страницу входа в систему. Если же пользователь аутентифицирован, посредник позволит запросу пройти далее в приложение.

https://laravel.su/docs/10.x/middleware

php artisan make:middleware CheckName

Django:

https://django.fun/docs/django/5.0/topics/http/middleware/

https://django.fun/docs/django/5.0/ref/middleware/

# template - шаблонизаторы

https://laravel.su/docs/10.x/blade

HTML-формы не поддерживают действия PUT, PATCH или DELETE. Поэтому при определении роутов PUT, PATCH или DELETE, вызываемых из HTML-формы, надо добавить в нее скрытое поле _method

```html
<input type="hidden" name="_method" value="patch">
```

@method('patch')

@csrf

Межсайтовая подделка запроса – это разновидность вредоносного эксплойта, при котором неавторизованные команды выполняются от имени аутентифицированного пользователя.

https://laravel.su/docs/10.x/csrf

HTML-шаблоны:

https://laravel.su/docs/10.x/views

Генерация URL-адресов:

https://laravel.su/docs/10.x/urls


Django:

https://django.fun/docs/django/5.0/#the-template-layer

Расширение мастер шаблона дочерними шаблонами:

{% extends 'base.html' %}

{% block content %}{% endblock content %}

##  Функции для определния url на основе алиаса (имени)

в urls.py:

path('', views.index, name="home"),

в шаблонах:

{% url 'home' %}

в коде (функция reverse, котру нужно импортировать)

HttpResponseRedirect(reverse('home'))

HttpResponseRedirect(reverse('article.update', args=(1,)))

# Request\Response

https://laravel.su/docs/10.x/requests

https://laravel.su/docs/10.x/responses

Django:

https://django.fun/docs/django/5.0/ref/request-response/


# Маршрутизация

https://laravel.su/docs/10.x/routing

Маршруты регистрируются в файлах в каталоге routes. В проекте уже представлены логические разбиения роутеров: Web, console, api.

Параметры в пути указываются в фигурных скобках {id}

Если в пути несколько параметров, то они будут подставляться по порядку, а не по наименованию

Опциональные параметры указываются с вопросительным знаком {name?}


Django:

https://django.fun/docs/django/5.0/topics/http/urls/

# Контроллеры

Контроллеры могут группировать связанную с обработкой HTTP-запросов логику в отдельный класс.

php artisan make:controller CarController

php artisan make:controller CarController --api
php artisan make:controller CarController --invokable
php artisan make:controller CarController --resource --model Models/City

https://laravel.su/docs/10.x/controllers

Django:

https://django.fun/docs/django/5.0/topics/http/views/

https://django.fun/docs/django/5.0/ref/class-based-views

https://django.fun/docs/django/5.0/topics/class-based-views/

https://django.fun/docs/django/5.0/ref/class-based-views/mixins/

https://django.fun/docs/django/5.0/ref/class-based-views/mixins/

Формы:

https://django.fun/docs/django/5.0/topics/forms/

https://django.fun/docs/django/5.0/ref/forms/

# Валидация

https://laravel.su/docs/10.x/validation

Django:

https://django.fun/docs/django/5.0/#forms

# Файловое хранилище

Работа с файлами:

https://laravel.su/docs/10.x/filesystem

Как загружать файлы:

https://laravel.su/docs/10.x/requests#files

В первый раз после установки Laravel нужно запустить команду:

php artisan storage:link

Она создаст симлинк public/storage -> storage/app/public

Django:

(Раздел - Загрузка файлов)

https://django.fun/docs/django/5.0/#the-view-layer

создание в settings.py переменных:

```
STATIC_URL = 'static/'
STATICFILES_DIRS = [BASE_DIR / "static"]
```

создание папки static в папки проекта

Доступ к статики:

{% load static %}

{% static "css/style.css" %}

pillow:

https://pypi.org/project/pillow/

```
MEDIA_URL = "/media/"
MEDIA_ROOT = BASE_DIR / "media"
```

в urls.py проекта:

```
 + static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)
```



# Авторизация\Аутентификация

https://laravel.su/docs/10.x/authentication

https://laravel.su/docs/10.x/authorization

https://laravel.su/docs/10.x/session

```php

// Получить текущего аутентифицированного пользователя
$user = Auth::user();
$user = auth()->user()

// Получить текущего аутентифицированного пользователя по идентификатору
$id = Auth::id();
$id = auth()->id;

// Получить пользователя в запросе
$request->user()

```

Django:

Раздел - Аутентификация

https://django.fun/docs/django/5.0/#common-web-application-tools


# Логирование

https://laravel.su/docs/10.x/logging

В общем случае логирование используется для записи любой информации в единое место.

Каждая информация указанная для записи помечается определенным уровнем её важности и в зависимости от настройки системы логирования она либо записывается, либо игнорируется

Уровни важности:

- Emergency - system is unusable
- Alert - action must be taken immediately
- Critical - critical conditions
- Error - error conditions
- Warning - warning conditions
- Notice - normal but significant condition
- Informational - informational messages
- Debug - debug-level messages

Django:

https://django.fun/docs/django/5.0/topics/logging/

https://django.fun/docs/django/5.0/howto/logging/#logging-how-to


# Контейнер служб

https://habr.com/ru/post/655399/

https://laravel.su/docs/10.x/container

Контейнер служб (service container, сервис-контейнер)

зависимости классов «вводятся» в класс через конструктор в виде аргументов или, в некоторых случаях, через методы-сеттеры. При создании класса или вызове методов фреймворк смотрит на список аргументов и, если нужно, создаёт экземпляры необходимых классов и сам подаёт их на вход конструктора или метода.

DI (dependency injection) - Внедрение зависимости

Внедрение зависимостей (или Dependency Injection, сокращенно "DI") - явная передача зависимости в объект, который в ней нуждается извне, вместо создания зависимого объекта в коде нуждающегося.

Инъекция зависимостей происходит при помощи IoC контейнера

Буква D в SOLID

```php
$controller = (new \App\PostController())
    ->index(
        (new \App\ExampleDi())
            ->method2(
                App\ExampleDi2()
            )
    )
;
```

"auto-wiring" - автоматическое разрешение зависимостей

```php
$reflectionClass = new ReflectionClass(CLASS:CLASS);
```

ReflectionClass выступает аналитиком для нашего класса CLASS:CLASS, и в этом состоит главная идея Reflection API.

ReflectionClass: сообщает информацию о классе.


# Facade и интерфейсы

https://laravel.su/docs/10.x/facades

https://laravel.su/docs/10.x/contracts


Все основные компоненты Laravel реализуют интерфейсы, размещенные в репозитории illuminate/contracts. У этого репозитория нет внешних зависимостей, это скелет фреймворка. Этот удобный корневой набор интерфейсов, который вы можете использовать в DI (dependency injection) своих классов, может служить альтернативой фасадам.

Для чего нужны контракты? Зачем вообще нужны интерфейсы?

Ответ - слабая связность и упрощение кода.

Сервис-провайдеры – это центральное место начальной загрузки всех приложений Laravel. Ваше собственное приложение, а также все основные службы и сервисы Laravel загружаются через них.


## Facade

Объявление свойств и методов класса статическими позволяет обращаться к ним без создания экземпляра класса. К ним также можно получить доступ статически в созданном экземпляре объекта класса.

```php
Class Mail
{
	public static function __callStatic($method, $args)
	{
		return app('mail')->$method(...$args)
	}
}
```
