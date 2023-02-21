# Структура HTTP-запроса и ответа

```
POST /login HTTP/1.1
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
Accept-Encoding: gzip, deflate
Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,und;q=0.6,lv;q=0.5
Cache-Control: no-cache
Connection: keep-alive
Content-Type: application/x-www-form-urlencoded
Host: example.com
Pragma: no-cache
User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36

email=asdad%40gm.com&password=as2354234
```


## Методы

GET - получение ресурса, read

POST - создание ресурса, add

PUT - обновление, замена ресурса, place,replace

PATCH - частичная замена ресурса, edit

DELETE - удаление ресурса, delete

HEAD - получить заголовки

OPTIONS - получить список доступных методов

CONNECT and TRACE - исп. чтоб получить информацию о соединении к нашему серверу, вернет инф. о соеденении и трасировку запроса

```
Book:
-price = 100
-name = Test Book
-description = Descr Boook
-title = Meta Book

PUT /book/1 HTTP/1.1

price=100&name=Test Book&description=Descr Boook&title=Meta Book

price=100

PATCH /book/1 HTTP/1.1

price=1

```

## Структура запроса

### CRUD

GET https://example.com/books

GET https://example.com/books/1

POST https://example.com/books

PUT https://example.com/books/1

PATCH https://example.com/books/1

DELETE https://example.com/books/1

PATCH https://example.com/books/1/like

```
Book:
-price = 100
-name = Test Book
-description = Descr Boook
-title = Meta Book
-like = 0

```

### Пример с GET - POST

GET https://example.com/books

GET https://example.com/books/1

POST https://example.com/books/create

POST https://example.com/books/1/update

POST https://example.com/books/1/patch

POST https://example.com/books/1/delete


### Параметры (query) в GET

GET https://example.com/books?sort=name&filter[name]=Alex

URI - Uniform Resource Identifier - унифицированный идентификатор ресурса - (эндпоинты)


## Безопасные методы и не безопасные

- GET
- HEAD
- OPTIONS

## Идемпотентность методов

### Идемпотентные:

- GET
- HEAD
- PUT
- DELETE
- OPTIONS

Если на сервер после повторных запросов ничего не меняется, то этот метод является - идемпотентным




## Коды ответов:

https://www.webfx.com/web-development/glossary/http-status-codes/

Коды состояния HTTP 1xx — информационные ответы. Они указывают на то, что ваш веб-браузер сделал запрос на сервер и ожидает ответа.

Коды состояния HTTP 2xx — успешные ответы. Эти коды состояния сообщают клиенту, то есть веб-браузеру, что всё обрабатывается должным образом.

Коды состояния HTTP 3xx — перенаправления. Запрос получен, но для его выполнения нужен дополнительный шаг.

Коды состояния HTTP 4xx — ошибки на стороне клиента. Клиент сделал запрос, но целевая страница неверна.

Коды состояния HTTP 5xx — ошибки на стороне сервера. Запрос клиента был правильным, но сервер не смог его доставить.

### 2xx

200 — ОК - Запрос клиента выполнен успешно.

201 — Создан - Created - Запрос клиента выполнен успешно, и был создан новый ресурс. Это обычный ответ для метода POST и иногда для метода PUT.

204 — Нет содержимого - No Content - Действие выполнено успешно, но содержимое не возвращено. Полезно для действий, для которых не требуется тело ответа, например для DELETE. То есть если вы использовали DELETE, то тело ответа не нужно, значит, всё верно.

### 3xx

301 — Переехал навсегда - Moved Permanently - Ресурс перемещён в другое место, и местоположение известно.

302 — Переехал временно - Found - Запрашиваемый документ был найден и расположен временно по другому адресу.

304 — Не изменён - Not Modified - Запрошенный ресурс не был изменён. Чаще всего используется для кеширования

### 4xx

400 — Неверный запрос - Bad Request - В отправленном запросе есть проблемы, например, могут отсутствовать некоторые обязательные параметры. Часто к ответу 400 добавлено сообщение об ошибке, которое вы можете использовать для исправления запроса.

401 — Несанкционированный - Unauthorized - Особенно полезно для аутентификации, когда запрошенный ресурс недоступен для пользователя, владеющего запросом.

403 — Запрещено - Forbidden - Клиенту отказано в доступе к запрошенному ресурсу из-за отсутствия у клиента необходимых разрешений.

404 — Не найдено - Not Found - Предоставленный URL-адрес не идентифицирует какой-либо ресурс.

405 — Метод запрещён - Method Not Allowed - Используемый метод HTTP не разрешён для конкретного ресурса.

410 - Ушел - Gone - Целевой ресурс больше недоступен на исходном сервере, и это состояние, вероятно, будет постоянным.

422 — Необрабатываемый объект - Unprocessable Entity  - сервер понимает тип содержимого объекта запроса, и синтаксис объекта запроса правильный, но ему не удалось обработать содержащиеся в нем инструкции.


### 5xx

500 — Внутренняя ошибка сервера - Общий код ошибки, когда возникает непредвиденное условие и происходит сбой сервера.

502, 504 - Bad Gateway, Gateway Timeout - Сервер, действуя как шлюз или прокси, получил недопустимый ответ от входящего сервера, к которому он обращался при попытке выполнить запрос.

503 — Сервис недоступен - Запрос не выполнен из-за проблем с сервером. Чаще всего такое происходит, когда сервер перезагружается или находится на обслуживании. Также код появляется, когда серверу не хватает ресурсов или памяти.


# Версия протокола - Сайты и доменные имена

https://i.gyazo.com/465e5154d825bbaf8f88c60d8e2854f8.png

https://i.gyazo.com/fd87416fb0aeb40b711479c6fdae1ae5.png

HTTPS2: Pseudo-Header Fields

:authority: example.com

# Итого:

в запросе и ответе нужно указывать:

- версию HTTP
- метод запроса
- адрес ресурса к которму обращаемся

любой запрос к серверу и ответ от сервера по протоколу HTTP, состоит из мета данных, которые указываются в начале, после метаданных
(2ойного перевода строки), возвращается контент или передается контент

контент - тело запроса или ответа (body), а мета информация которая приведена в начале запроса-отвеа - HTTP заголовки

Заголовки HTTP (англ. HTTP Headers) — это строки в HTTP-сообщении, содержащие разделённую двоеточием пару имя-значение. Формат заголовков соответствует общему формату заголовков текстовых сетевых сообщений. Заголовки должны отделяться от тела сообщения хотя бы одной пустой строкой. (CRLF)

```
POST /create HTTP/1.1
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
Accept-Encoding: gzip, deflate
Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,und;q=0.6,lv;q=0.5
Cache-Control: no-cache
Connection: keep-alive
Host: example.com
Pragma: no-cache
Upgrade-Insecure-Requests: 1
User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36

Hello
```

# Заголовки для описания контента

## Content Type:

Заголовок-сущность Content-Type используется для того, чтобы определить MIME тип ресурса.

В ответах сервера заголовок Content-Type сообщает клиенту, какой будет тип передаваемого контента. В некоторых случаях браузеры пытаются сами определить MIME тип передаваемого контента, но их реакция может быть неадекватной.

- text/plain
- application/xml
- text/html
- text/csv
- text/javascript
- text/css
- application/pdf
- image/jpeg, image/png

![alt](https://i.gyazo.com/77508c2e60e14b5f24d3713ca17cef70.png)

application/octet-stream - Этот тип является базовым для бинарных данных. В связи с тем, что он подразумевает неопределённые бинарные данные

## Accept, Content-Length

HTTP заголовок запроса Accept указывает, какие типы контента, выраженные как MIME типы, клиент может понять.

Charset - Заголовок Accept-Charset запроса HTTP сообщает какую кодировку клиент может понять.

Content-Length - Заголовок Content-Length указывает размер отправленного получателю тела объекта в байтах.

Accept-Language - Запрос Accept-Language сообщает серверу, какие языки клиент понимает и какая локаль предпочтительнее

```
Request:
GET /books
Host: example.com
Accept: application/json

Response
HTTP/1.1 200 OK
Content Type: application/json
Content-Length: 120

[
	{
		"name": "HELLO!"
	}
]

```

```

Request:
POST /books
Host: example.com
Content-Lenght: 150
Accept: application/json
Content Type: application/json

{
	"name": "Book 1",
	"price": "500"
}

Response:
HTTP/1.1 201 CREATED
Content Type: application/json
Content-Lenght: 150

{
	"name": "Book 1",
	"price": "500"
}

```


```

Request:
POST /books
Host: example.com
Content-Lenght: 200
Accept: application/json
Content Type: application/xml

<?xml version="1.0" encoding="UTF-8"?>
<book>
	<name>Book 1</name>
	<price>500</price>
</book>

Response:
HTTP/1.1 200 OK
Content Type: application/json
Content-Lenght: 150

{
	"name": "Book 1",
	"price": "500"
}

```

## Urlencoded

Content-Type: application/x-www-form-urlencoded

```

Request:
POST /books
Host: example.com
Content-Lenght: 200
Accept: application/json
Content Type: application/x-www-form-urlencoded

name=Book+1&price=500

```

## Проблема с файлами

```

Request:
POST /books
Host: example.com
Content-Lenght: 150
Accept: application/json
Content Type: application/json

{
	"name": "Book 1",
	"price": "500",
	"file": "BASE64"
}

Response:
HTTP/1.1 201 CREATED
Content Type: application/json
Content-Lenght: 150

{
	"name": "Book 1",
	"price": "500",
	"image": "/images/books_1_preview.png"
}

```


```

-----
Reqeust:
POST /books
Host: example.com
Content-Lenght: 150000
Content-Type: multipart/form-data; boundary="XSfdaas123sd"
Accept: application/json

--XSfdaas123sd
Content-Disposition: form-data;name="name"

Book 1

--XSfdaas123sd
Content-Disposition: form-data;name="photo"; filename="photo.jpg"
Content-Type: image/jpeg

ЯШФЫАВ№;ЕХЪ№;%№;%№%;

--XSfdaas123sd


Response:
HTTP/1.1 201 CREATED
Content Type: application/json
Content-Lenght: 150

{
	"name": "Book 1",
	"price": "500",
	"image": "/images/books_1_preview.png"
}


```

https://restapitutorial.ru/lessons/httpmethods.html

https://habr.com/ru/company/hexlet/blog/274675/
