# Кроссдоменные запросы (CORS)

Использование Origin-заголовков для возможности из JavaScript осуществлять Ajax-запросы к API на другом домене.

## Same Origin Policy

У любого браузера в целях безопасности есть некая policy.

Политика одинакового источника (same-origin policy) определяет как документ или скрипт, загруженный из одного источника (origin), может взаимодействовать с ресурсом из другого источника. Это помогает изолировать потенциально вредоносные документы, снижая количество возможных векторов атак.

Две страницы имеют одинаковый origin (источник) если протокол, порт (если указан), и хост одинаковый для обеих страниц.

Браузер рассматривает как разные сайты

https://example.com

->
http://example.com:77

http://example.com

https://api.example.com

https://api.example.com:8700

http://api.example.com

## Ограничения со сторонними ресурсами:

- XMLHttpRequest - Fetch API
- Web Fonts
- WebGL Textures
- Canvas (img)


```
// https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap
fetch('https://example.com/movies.json')
  .then((response) => {
    return response.text();
  })
  .then((data) => {
    console.log(data);
  });
```

## Методы и заголовки

Белый список методов и заголовков который браузер использует в своей политике работы с разными сайтами из js.

Именно эти методы браузер считает безопасными и с помощью которых сложно в принципе сломать другой сайт.

**Методы:**

- GET
- POST
- HEAD

**Заголовки:**

- Connection, User-agent, Content-Length ....
- Accept
- Accept-Language
- Content-Language
- Content-Type
 - application/x-www-form-urlencoded
 - multipart/form-data
 - text/plain


## Простой запрос и Preflighted Request (подготовительный запрос)

Все запросы из js которые отправляются на сторонние сайты и соответствуют этому списку, браузер отправляет сразу напрямую в виде простого запроса.

Если отправить запрос через js др домена, то будет ошибка CORS

(если зайти по ссылке, то никакие политики не работают)

Чтоб блокироваки не происходило и разрешить доступ к этому api с др. сайтов, сервер должен вернуть заголовок

Access-Control-Allow-Origin: *

### Preflighted Request - подготовительный запрос

Как только браузер сомневается в чем то, он вместо оригинального запроса сначало отправляет OPTIONS запрос, которым проверяет можно ли с этим сервером работать.
Если вернулся валидный ответ, только в этом случаем отправляются "опасные запросы".

```
OPTIONS /example
Host: https://ex.com
Origin: https://example.com
Access-Control-Request-Method: POST
Access-Control-Request-Headers: content-type

Response:
HTTP/1.1 200 OK
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: GET, POST, OPTIONS (OPTIONS)
Access-Control-Expose-Headers: Content-Type

```

Есть список запрещённых HTTP-заголовков, которые мы не можем установить:

```
Accept-Charset, Accept-Encoding
Access-Control-Request-Headers
Access-Control-Request-Method
Connection
Content-Length
Cookie, Cookie2
Date
DNT
Expect
Host
Keep-Alive
Origin
Referer
TE
Trailer
Transfer-Encoding
Upgrade
Via
Proxy-*
Sec-*
```


## Cookies

Для работы с Cookies сервер должен возвращать

Access-Control-Allow-Credentials: true

при options и при других методах

и важно указать в Access-Control-Allow-Origin точный домен, к какому домену будут привязываться Cookies

FETCH API:

credentials: 'include': Чтобы браузеры могли отправлять запрос с учётными данными (даже для cross-origin запросов)

credentials: 'same-origin': если URL принадлежит одному источнику (origin) что и вызывающий его скрипт

credentials: 'omit': учётные данные не передаются с запросом

## Access-Control-Expose-Headers

Позволяет серверу указать, какие заголовки ответов должны быть доступны для сценариев, работающих в браузере, в ответ на запрос из другого источника.

По умолчанию отображаются только заголовки ответов, внесенные в список надежных отправителей CORS. Чтобы клиенты могли получить доступ к другим заголовкам, сервер должен перечислить их, используя заголовок Access-Control-Expose-Headers.

Available Headers:

- Cache-Control
- Content-Language
- Content-Type
- Expires
- Last-Modified
- Pragma

## Max Age

указываем сколько секунд хранить

Access-Control-Max-Age: 3600

## Итог

Access-Control-Allow List:

- Access-Control-Allow-Origin
- Access-Control-Allow-Methods
- Access-Control-Allow-Headers
- Access-Control-Allow-Credentials
- Access-Control-Expose-Headers
- Access-Control-Max-Age



# API

Фронтенд с бэкендом взаимодействуют через API. И от того, какой это API, насколько хорошо или плохо бэкенд и фронтенд договорились между собой, зависит весь результат разработки.

Application Programming Interface (API) — «программный интерфейс приложения»

API можно рассматривать как соглашение между двумя сторонами. API не только обеспечивает возможность обмена данными, но и устанавливает его правила.

API и клиент должны передавать заголовки Content-Type и Accept.

Если API построен на JSON, передавайте

Accept: application/json

Content-Type: application/json.

API - всегда велосипедостроение.

## Как не писать

```
GET /getBook?id=1
GET /getBookAll
GET /createBook
POST /createBook
POST /updateBook
```

**Логичный пример**

```
GET /books
GET /books/{book}
POST /books
PUT{PATCH} /books/{book}
DELETE /books/{book}
GET /books/show
PATCH /books/{book}/change-order
PUT /books/{book}/assign-author/{author}
DELETE /books/{book}/remove-image/
```

## Пагинация

/books?page=2&page_size=10

**Логичный пример**

GET /books?page[size]=30&page[number]=2

или

GET /books?page[offset]=30&page[limit]=30


```
{
	"data": [{ "id": 1, "title": "book 1"}, ...],
	"meta": { "count": 60, "start": 1, "last": 100 }
}
```

## Сортировка

GET /books?sort_by_title_asc

GET /books?sort_by_title_desc

GET /books?sort_price=desc

GET /books?sort_price=asc

**Логичный пример**

GET /books?sort=title

GET /books?sort=-title

asc

desc

## Поиск - Фильтр

GET /posts?filter[id][]=1&filter[id][]=3&filter[id][]=5

GET /posts?search_name=asdadad

GET /posts?search_name=asdadad

GET /posts?search_price=100&search_name=asdadad

GET /posts?search_price_gt=100&search_name_like=asdadad


**Логичный пример**

GET /posts?filter[id]=1,2,3

GET /posts?filter[name]=Test

GET /posts?filter[price]=100

GET /posts?filter[price][NEQ]=100

GET /posts?filter[price][GT]=100

GET /posts?filter[name][LIKE]=Test


EQ - оператор равенства, где значения точно совпадают.

NEQ - не равно, если значения не совпадают.

LIKE - где значение соответствует указанному шаблону.

LT - меньше указанного значения

LE (LTE) - меньше или равно указанному значению

GT - больше указанного значения

GE (GTE) - больше или равно указанному значению


## Sparse Fieldsets - Выбор определенных полей

GET /books?select=title,author,price

GET /books?select_book=title,author,price&select_author=name

**Логичный пример**

GET /books?fields[book]=title,price

GET /books?fields[book]=title,price&fields[author]=name,email

## Проблема N+1

Допустим, нужно вывести список из 10 статей. Мы загружаем список статей, у каждой статьи есть категория, и для каждой нужно загрузить категорию.

Можно использовать специальный GET-параметр, назвать его include , говоря, какие связи нам нужно загрузить вместе со статьями.

Допустим, мы загружаем статьи, и хотим вместе со статьями сразу же получить еще и категорию. Ответ выглядит так:


```
{
  "data": [
    {
      "id": "1",
      "title": "Test Title",
      "relationships": {
        "category": {
          "data": {
            "name": "FirstCategory",
            "id": "9"
          }
        }
      }
    },
    {
      "id": "2",
      "title": "Test Title 2",
      "relationships": {
        "category": {
          "data": {
            "name": "FirstCategory",
            "id": "9"
          }
        }
      }
    }
  ]
}
```

## Проблема дублирования данных

```
{
  "data": [
    {
      "id": "1",
      "title": "Test Title",
      "relationships": {
        "category": {
          "data": {
            "id": "9"
          }
        }
      }
    },
    {
      "id": "2",
      "title": "Test Title 2",
      "relationships": {
        "category": {
          "data": {
            "id": "9"
          }
        }
      }
    }
  ]
}
```

/articles?include=category

```
{
  "data": [
    {
      "id": "1",
      "title": "Test Title",
      "relationships": {
        "category": {
          "data": {
            "id": "9"
          }
        }
      }
    },
    {
      "id": "2",
      "title": "Test Title 2",
      "relationships": {
        "category": {
          "data": {
            "id": "9"
          }
        }
      }
    }
  ],
  "included": [
    {
      "category": {
        "data": {
          "name": "FirstCategory",
          "id": "9"
        }
      }
    }
  ]
}
```

# HATEOAS

https://habr.com/ru/post/483328/

Термин HATEOAS означает фразу «Hypermedia As The Engine Of Application State» (Гипермедиа как двигатель состояния приложения).

С помощью HATEOAS ответы на запросы REST возвращают не только данные, но и действия, которые можно выполнить с ресурсом.

![alt](https://hsto.org/webt/bh/d5/or/bhd5or6wjb-8rn_wn0fklsazynk.png)

**пример с HATEOAS**

![alt](https://hsto.org/webt/wf/w3/xn/wfw3xnklhpyr5kekaqla8f0cvto.png)

![alt](https://hsto.org/webt/cz/7l/nq/cz7lnqx2clwstyhbfehxfps7fbo.png)


https://the-one-api.dev/documentation

# JSON API

https://jsonapi.org/

https://django-rest-framework-json-api.readthedocs.io/en/stable/getting-started.html

https://laraveljsonapi.io/docs/3.0/

http://127.0.0.1:8000/api/v1/authors?page[number]=1&page[size]=5

http://127.0.0.1:8000/api/v1/books?fields[books]=title,authors&fields[authors]=first_name&include=authors


Спецификация JSON API решает ряд проблем — общее соглашение для всех.

Минусы:

- Контроль вложенности — include можно залезть очень далеко;

include=authors.books.comments.tags.meta

- Сложность запросов к БД — они строятся иногда автоматически, и получаются очень тяжелыми;
- Не все библиотеки реализуют спецификацию хорошо — это проблема Open Source.

Одни и те же вещи можно неоднозначно сформулировать:

- GET /posts/1?include=comments  — запрашиваем статью с комментариями;
- GET /posts/1/comments  — запрашиваем комментарии к статье;
- GET /comments?filters[posts]=1  — запрашиваем комментарии с фильтром по статье.

Количество relationships в выдаче не ограничено. Если мы делаем include, запрашиваем статьи, добавляя к ним комментарии, то в ответ нам придут все комментарии этой статьи. Есть 10 000 комментариев — получи все 10 000 комментариев:

GET /articles/1?include=comments

GET /comments?filters[article]=1&page[size]=30

или 2 запроса

GET /articles/1

GET /comments?filters[article]=1&page[size]=30

**GET**

filter: /posts?filters[name][LIKE]=Test&filters[author.name]=John

sort: /books?sort=title

select: /books?fields[book]=title,price&fields[author]=name,email

include: Описание логики отношений

/articles/1?include=comments


**PATCH-PUT-POST**


```
POST /books HTTP/1.1
Content-Type: application/vnd.api+json
Accept: application/vnd.api+json

{
  "data": {
    "type": "books",
    "attributes": {
      "isbn": "fghdgfdgd345345",
      "title": "hello",
      "price": "100",
      "page": 100,
      "year": 200,
      "excerpt": "asdasd"
    },
    "relationships": {
      "authors": {
        "data": [
          { "type": "authors", "id": "1" },
          { "type": "authors", "id": "2" }
        ]
      }
    }
  }
}

```

```
PATCH /books/57 HTTP/1.1
Content-Type: application/vnd.api+json
Accept: application/vnd.api+json

{
  "data": {
    "id": "57",
    "type": "books",
    "attributes": {
      "isbn": "fghdgfdgd345345"
    }
  }
}



```

# OPEN API


OpenAPI представляет собой формализованную спецификацию и полноценный фреймворк для описания, создания, использования и визуализации веб-сервисов REST.

Swagger - это фреймворк для спецификации RESTful API. Он дает возможность не только интерактивно просматривать спецификацию, но и отправлять запросы – так называемый Swagger UI.

Причиной появления Swagger было стремление к созданию системы автоматического генерирования документации для REST API, а так же — желание автоматизации тестирования API

OpenAPI — это современное название спецификации, а словом «Swagger» обычно называют инструменты, построенные на основе этой спецификации.

Swagger UI - позволяет визуализировать ресурсы API и взаимодействовать с ними без какой-либо логики реализации. Он автоматически генерируется из вашей спецификации OpenAPI, а визуальная документация упрощает внутреннюю реализацию и использование на стороне клиента.


Swagger имеет два подхода к написанию документации:

- Документация пишется на основании кода.
- Документация пишется отдельно от кода.

Данный подход требует знать синтаксис Swagger Specification.

Документация пишется либо в YAML/JSON файле, либо в редакторе Swagger Editor.

https://swagger.io/specification/

https://editor.swagger.io/

https://starkovden.github.io/step1-openapi-object.html

https://github.com/DarkaOnLine/L5-Swagger


# graphql

https://docs.graphene-python.org/

https://github.com/graphql-python/graphene-django/tree/main/examples/cookbook

https://graphql.org/

В двух словах, GraphQL это синтаксис, который описывает как запрашивать данные, и, в основном, используется клиентом для загрузки данных с сервера. GraphQL имеет три основные характеристики:

- Позволяет клиенту точно указать, какие данные ему нужны.
- Облегчает агрегацию данных из нескольких источников.
- Использует систему типов для описания данных.

https://lighthouse-php.com/6/getting-started/installation.html#install-via-composer

https://github.com/mll-lab/laravel-graphiql

https://laravel.demiart.ru/graphql-laravel/

# gRPC

https://yandex.cloud/ru/docs/glossary/grpc

https://habr.com/ru/companies/otus/articles/780720/

https://habr.com/ru/companies/yandex/articles/484068/
