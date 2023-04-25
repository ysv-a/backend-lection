# Безопасность

XSS - нарушение синтаксиса HTML или JS

SQL Injection - нарушение синтаксиса SQL

(это внедрение некого кода в процесс построения sql запроса)

Header Injection  - нарушение синтаксиса HTTP

https://portswigger.net/web-security/host-header

## Недостаток контроля доступа и аутентификации:

IDOR - доступ к объекту

Account Takeover - получение доступа к аккаунту путем  обхода алгоритмов  авторизации

Source Code Disclosure - доступ к исходному коду или к файлам  конфигурации

https://web.dev/secure/

https://portswigger.net/web-security/

# SQL Injection

Если отправляем данные в sql, то используем подготовленные запросы и плейсхолдер.

Placeholder - с помощью этого, бд узнает что значение ?, никогда не будет интерпретироваться как набор команд и будет восприниматься как значения.


```php
$username = $_POST['username'];

$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `username` = :username");
$stmt->execute(['username' => $username]);

$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `username` = ?");
$stmt->execute([$username]);

$stmt = pdo()->query("SELECT * FROM `users` WHERE `username` = '{$username}'");
```

python sqlmap.py -u "http://localhost:8888/index.php" --random-agent -f --banner --current-user --passwords --tables --exclude-sysdbs --forms

python sqlmap.py -u "http://localhost:8888/index.php" --random-agent --dump -D app -T users --dump-format=SQLITE --forms

# XSS

если отправляем данные в html (в шаблон), то используем экранирование

# CSRF

Cross Site Request Forgery

CSRF - Межсайтовая подделка запроса

Межсайтовая подделка запроса – это разновидность вредоносного эксплойта, при котором неавторизованные команды выполняются от имени аутентифицированного пользователя.

SameSite — предназначен для обеспечения некоторой защиты от атак подделки межсайтовых запросов

– None, в этом случае ограничения на файлы Cookie не устанавливаются;

– Strict, устанавливается полный запрет на отправку любых Cookie;

Если вы установите для атрибута SameSite значение Strict, ваш файл cookie будет отправляться только для внутрисайтовых запросов. Говоря языком пользователей, файл cookie будет отправлен только в том случае, если сайт для файла cookie совпадает с сайтом, который в данный момент отображается в адресной строке браузера

– Lax, в этом случае файлы Cookie полностью блокируются для межсайтовых запросов (включая изображения, iframe и т.д.).

# Загрузка файлов

https://laravel.su/docs/8.x/filesystem

При использовании драйвера local все операции с файлами выполняются относительно корневого каталога, определенного в файле конфигурации filesystems. По умолчанию это значение задано каталогом storage/app.

Диск public, определенный в файле конфигурации filesystems вашего приложения, предназначен для файлов, которые будут общедоступными. По умолчанию публичный диск использует драйвер local и хранит свои файлы в storage/app/public.

Чтобы сделать эти файлы доступными из интернета, вы должны создать символическую ссылку на storage/app/public в public/storage.

php artisan storage:link

# Ошибки и логирование

В production никогда не выводим подробный отчет об ошибках, все должно хранится в логах.

Файлы .txt, .log, env, .csv, .sql и все возможные конфиги не храним в открытом доступу

# Поиск информации в гугле:

Операторы google

Это часть примеров, вообще полезно анализировать сайт по таким запросам

```
site:example.com filetype:txt
site:example.com ext:pdf
site:example.com allintext:password filetype:log
site:example.com filetype:env
site:example.com ext:csv intext:"password"
site:example.com filetype:inc
```

https://www.colorado.edu/cmci/academics/journalism/international-media-certificate-application

открытые скрипты:

```
inurl:"forcedownload.php?file="
inurl:"filedown.php?file="
inurl:"file.php?file="
https://www.svamgroup.ru/download/file.php?file=/upload/iblock/9ac/logotip-klaster_nadpis.pdf
https://www.svamgroup.ru/download/file.php?file=../../../../../../../etc/ucf.conf
```

http://localhost:8888/filedownload.php?file=database.sql
http://localhost:8888/filedownload.php?file=/../../../etc/ucf.conf

## Дорки

Дорки - запросы для получения закрытой информации используя поисковые операторы

https://www.exploit-db.com/google-hacking-database

# Заголовки

https://habr.com/ru/companies/southbridge/articles/471746/

https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy

https://observatory.mozilla.org/

Content-Security-Policy

CSP применяется, чтобы предотвращать межсайтовый скриптинг — путем определения, какие ресурсы могут быть загружены.


Strict-Transport-Security

Этот заголовок сообщает браузеру, что на сайт заходить можно только по протоколу HTTPS
Strict-Transport-Security: max-age=3600; includeSubDomains

Время, в секундах, которое браузер должен помнить, что сайт доступен только с помощью HTTPS.
Если этот опциональный параметр задан, то правило также применяется ко всем саб-доменам сайта.

X-Content-Type-Options

Благодаря этому заголовку браузеры придерживаются типов MIME, установленных приложением, что помогает предотвратить часть атак с межсайтовым скриптингом.

X-Content-Type-Options: nosniff

Блокирует запрос, если запрошенный тип:

- "style" и его MIME не "text/css", или
- "script" и его MIME не JavaScript MIME-тип

X-XSS-Protection - Этот заголовок приказывает браузеру прервать выполнение обнаруженных атак межсайтового скриптинга.

X-XSS-Protection: 1; mode=block

X-Frame-Options - Этот заголовок разрешает отображение сайта в iFrame.

DENY - Страница не может отображаться во фрейме

SAMEORIGIN - Страница может отображаться только во фрейме того же источника, что и сама страница.

## Кликджекинг

Поместив ваш веб-сайт в iFrame, вредоносный ресурс получает возможность произвести кликджекинг атаку — запустив некий JavaScript, который обманом вынудит пользователя кликнуть по iFrame, а после начнет взаимодействовать с ресурсом от его, пользователя, имени (то есть человек кликнет по вредоносной ссылке или кнопке, даже не подозревая об этом!).

пример: деанонимизации посетителей сайта
Наиболее часто к ней прибегают для идентификации ID в социальных сетях («ВКонтакте», Facebook, Twitter и др.).

Злоумышленник скрывает в прозрачном iFrame кнопку из социальной сети («Мне нравится», Follow и т. п.). Невидимый глазу iFrame размещается над элементом страницы, на который пользователь должен нажать

Посетитель страницы жмет на скрытую кнопку — допустим, это «лайк» или вступление в группу во «ВКонтакте».
Злоумышленник таким образом получает информацию о профиле пользователя в соцсети и, как правило, прямой доступ к нему через личные сообщения или по контактным данным, если такие указаны на странице.

# OWASP

https://owasp.org/www-project-top-ten/

https://proglib.io/p/chto-takoe-top-10-owasp-i-kakie-uyazvimosti-veb-prilozheniy-naibolee-opasny-2021-09-09

# TWAPT

https://habr.com/ru/company/pentestit/blog/551978/

https://github.com/MoisesTapia/TWAPT

# Shodan

поисковая система для устройств, подключенных к Интернету.

https://www.shodan.io/search?query=redis
