# Форматы данных

## XML

XML-документ состоит из деклараций, элементов, комментариев, специальных символов и директив.

Стандарт XML резервирует только одну директиву `<?xml version="1.0"?>`, указывающую на версию языка XML, которой соответствует данный документ. В действительности, эта директива несколько богаче и в самом общем виде выглядит так:

Здесь атрибут encoding задает кодировку символов документа.

Все имена элементов, атрибутов и разделов должны начинаться с буквы Unicode и состоять из букв, цифр, символов точки (.), подчеркивания (_) и дефиса (-). Единственное ограничение состоит в том, что они не должны начинаться с комбинации букв xml в любом регистре; подобные имена зарезервированы для будущих расширений языка. Существенно, что стандарт допускает использование в именах не только английских букв, но и любых других, хотя существующие XML-процессоры часто ограничены теми системами кодировок, которые в них заложены создателями. Поэтому мы в своих примерах пишем имена по-английски. Данные, т. е. содержимое элементов и значения атрибутов, могут состоять из любых символов, кроме перечисленных в следующем разделе.


```xml

<?xml version="1.0" encoding="UTF-8"?>
<recipe name="хлеб" preptime="5" cooktime="180">
    <title>Простой хлеб</title>
    <ingredient amount="3" unit="стакан">Мука</ingredient>
    <ingredient amount="0.25" unit="грамм">Дрожжи</ingredient>
    <ingredient amount="1.5" unit="стакан">Тёплая вода</ingredient>
    <ingredient amount="1" unit="чайная ложка">Соль</ingredient>
    <Instructions>
        <step>Смешать все ингредиенты и тщательно замесить.</step>
        <step>Закрыть тканью и оставить на один час в тёплом помещении.</step>
        <step>Замесить ещё раз, положить на противень и поставить в духовку.</step>
    </Instructions>
</recipe>



```

### Специальные символы

Ряд символов в языке XML зарезервирован и должен представляться специальным образом:

- левая угловая скобка `("<") &lt`;
- правая угловая скобка `(">") &gt`;
- амперсант `("&") &amp`;
- двойная кавычка (") в значениях атрибутов `&quot`;
- одинарная кавычка (') в значениях атрибутов `&apos`;

При желании можно пользоваться числовой кодировкой символов в стандарте Unicode. При этом символ может быть задан своим десятичным кодом `(&#код;)` или шестнадцатеричным кодом `(&#xкод;)`. Например `&#169;` представляет символ авторского права `©`, а `&#x410;` – русскую букву `А`

```php
$str = 'Company & Company 2 > Company 3'
htmlspecialchars($str) // Преобразует специальные символы в HTML-сущности

// Company &amp; Company 2 &gt; Company 3

```

### CDATASection

Интерфейс CDATASection представляет собой раздел CDATA, который может быть использован внутри XML для добавления extended групп "незакавыченного" текста. Символы < and & не нуждаются в кавычках, как внутри раздела CDATA.

Весь текст в XML-документе будет проанализирован синтаксическим анализатором.

Но текст внутри раздела CDATA будет игнорироваться синтаксическим анализатором.

Термин CDATA используется для текстовых данных, которые не должны анализироваться синтаксическим анализатором XML.

```xml
<layout>  <![CDATA[<H1>Заголовок</H1>]]> </layout>
```

```js
<script type="text/javascript">
    //<![CDATA[
        document.write("<");
    //]]>
</script>

<script type="text/javascript">
<!--//--><![CDATA[//><!--
(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(123, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
//--><!]]>
</script>


```

(Главное отличие XHTML от HTML заключается в обработке документа. Документы XHTML обрабатываются своим модулем (парсером) аналогично документам XML. )

## XML Schema

XML Schema — язык описания структуры XML-документа. Спецификация XML Schema является рекомендацией W3C.

XML Schema, как и большинство языков описания данных XML, был задуман для определения правил, которым должен подчиняться документ. Но в отличие от других языков описания данных он был разработан так, чтобы его можно было использовать в создании программного обеспечения для обработки XML-документов.

После проверки документа на соответствие XML Schema читающая программа может создать модель документа, которая включает:

- словарь (названия элементов и атрибутов);
- модель отношений между элементами и атрибутами и их структуру;
- типы данных элементов и атрибутов.

```xml
<?xml version="1.0" encoding="UTF-8"?>
<xsd:schema xmlns:xsd="http://www.w3.org/2001/XMLSchema"
            targetNamespace="http://www.sitemaps.org/schemas/sitemap/0.9"
            xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
            elementFormDefault="qualified">
  <xsd:annotation>
    <xsd:documentation>
      XML Schema for Sitemap files.
      Last Modifed 2008-03-26
    </xsd:documentation>
  </xsd:annotation>


  <xsd:simpleType name="tLoc">
    <xsd:annotation>
      <xsd:documentation>
        REQUIRED: The location URI of a document.
        The URI must conform to RFC 2396 (http://www.ietf.org/rfc/rfc2396.txt).
      </xsd:documentation>
    </xsd:annotation>
    <xsd:restriction base="xsd:anyURI">
      <xsd:minLength value="12"/>
      <xsd:maxLength value="2048"/>
    </xsd:restriction>
  </xsd:simpleType>

    <!-- .... -->

</xsd:schema>
```


Пример документа, соответствующего этой схеме:


```xml
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="https://example.com/main-sitemap.xsl"?>
	<url>
		<loc>https://example.com/page1</loc>
		<lastmod>2022-12-07T05:15:18+02:00</lastmod>
	</url>
	<url>
		<loc>https://example.com/page2</loc>
		<lastmod>2022-12-07T05:15:18+02:00</lastmod>
	</url>
</urlset>
```

Пример:

https://sibzodchiy.ru/post-sitemap.xml

Пример RSS:

```xml


<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">

<channel>
  <title>W3Schools Home Page</title>
  <link>https://www.w3schools.com</link>
  <description>Free web building tutorials</description>
  <item>
    <title>RSS Tutorial</title>
    <link>https://www.w3schools.com/xml/xml_rss.asp</link>
    <description>New RSS tutorial on W3Schools</description>
  </item>
  <item>
    <title>XML Tutorial</title>
    <link>https://www.w3schools.com/xml</link>
    <description>New XML tutorial on W3Schools</description>
  </item>
</channel>

</rss>

```

# YAML

YAML (рекурсивный акроним YAML Ain't Markup Language — «YAML — Не язык разметки») — «дружественный» формат сериализации данных, концептуально близкий к языкам разметки, но ориентированный на удобство ввода-вывода типичных структур данных многих языков программирования.

В трактовке названия отражена история развития: на ранних этапах YAML расшифровывался как Yet Another Markup Language («Ещё один язык разметки») и даже позиционировался как конкурент XML, но позже был переименован с целью акцентировать внимание на данных, а не на разметке документов.

YAML призван:

- быть легко понятным человеку;
- поддерживать структуры данных, родные для языков программирования;
- быть переносимым между языками программирования;
- использовать цельную модель данных для поддержки обычного инструментария;
- поддерживать потоковую обработку;
- быть выразительным и расширяемым;
- быть лёгким в реализации и использовании;


```yaml

version: "3.7"

services:
  wordpress:
    container_name: "wordpress"
    build:
      context: .
      dockerfile: ./.docker/Dockerfile.wordpress
    links:
      - db
    env_file:
      - ./.docker/wordpress.env
    volumes:
      - ./.docker/.bashrc:/root/.bashrc:cached
      - wordpress:/var/www/html
      - ssh:/root/.ssh
      - .:/var/www/html/wp-content/plugins/${DOCKER_APP_NAME}
    ports:
      - 80:80
    networks:
      - network

```


## Основные типы данных YAML

Scalar types - Это наиболее распространенный тип данных в YAML. Они представлены в виде пар «ключ-значение», как показано в следующем примере.

Значения в паре могут быть любого типа, например строки, числа, включая шестнадцатеричные, целые числа и т. д.

```yaml
language: Ruby
author: Yukihiro Matsumoto
country: Japan
```

**Строка**

```yaml
string: This is a string.
command: "sh interface | include Queueing strategy:"

string:
  Это очень длинная строка,
  которую сложно читать в однострочной записи,
  так как она вылезает за пределы окна.
```

**Числа**

Другой тип данных, поддерживаемый в YAML, — это числовые типы. Числовые типы включают целые, десятичные, шестнадцатеричные, восьмеричные и другие числовые типы.

```yaml

int: 100
hex: 0x7f000001
octal: 0177
float: 127.0
expo: 6.022e+23
```

**Список**

Список — это упорядоченная коллекция данных, доступ к которым возможен по их индексам. Вот пример простого списка, где все значения строки:

```yaml

elements:
  - element1
  - element2
  - element3
  - 2
  - element2
  - yes
  - no


list_level_1:
  - 2
  - element2
  - true
  - list_level_2:
    - element1
    - element2
    - element3

```

**Словарь**

Словарь — это набор данных по типу «ключ: значение». Словарь в YAML можно записать блоком:

```yaml

author:
  name: Ivan Katkov
  job: Tech writer
  skill: Normal

```

**Комментарии YAML**

```yaml

# This is a comment in YAML

```


**Якоря**

Якоря и псевдонимы — это конструкции YAML, которые позволяют сократить синтаксис повторения и расширить существующие узлы данных. Вы можете разместить Anchors ( &) на объекте, чтобы отметить многострочный раздел. Затем вы можете использовать *вызов Alias, который будет привязан позже в документе, для ссылки на этот раздел. Якоря и псевдонимы очень полезны для больших проектов, поскольку они устраняют визуальный беспорядок, вызванный лишними линиями.

Псевдоним, по сути, действует как команда «см. Выше», которая заставляет программу приостанавливать стандартный обход, возвращаться к точке привязки, а затем возобновлять стандартный обход после завершения закрепленной части.

```yaml

definitions:
  steps:
    - step: &build-test
        name: Build and test
        script:
          - mvn package
        artifacts:
          - target/**

pipelines:
  branches:
    develop:
      - step: *build-test
    master:
      - step: *build-test

```

# JSON

JSON (JavaScript Object Notation) - простой формат обмена данными, удобный для чтения и написания как человеком, так и компьютером.

JSON основан на двух структурах данных:

- Коллекция пар ключ/значение. В разных языках, эта концепция реализована как объект, запись, структура, словарь, хэш, именованный список или ассоциативный массив.
- Упорядоченный список значений. В большинстве языков это реализовано как массив, вектор, список или последовательность.

В JSON значения могут быть следующих типов:

- строка
- число
- объект (объект JSON)
- массив
- boolean
- null

**JSON5:**

JSON5 — предложенное расширение формата JSON в соответствии с синтаксисом ECMAScript 5

- Поддерживаются как однострочные, так и многострочные комментарии.
- Объекты и списки могут иметь запятую после последнего элемента (удобно при копировании).
- Ключи объекта могут быть без кавычек, если они являются валидными идентификаторами ECMAScript 5.
- Строки могут заключаться как в одинарные, так и в двойные кавычки.
- Числа могут быть в шестнадцатеричном виде, начинаться или заканчиваться десятичной точкой, включать Infinity, -Infinity, NaN и -NaN, начинаться со знака +.


**Строки в JSON должны записываться в двойных кавычках.**

```
{ "name":"John" }
```


**Числа в JSON должны быть целочисленными или с плавающей точкой.**

```
{ "age":30 }
```


**Значения в JSON могут быть объектами (Объекты как значения в JSON должны следовать тем же правилам, что и объекты JSON.)**

```
{ "employee":{ "name":"John", "age":30, "city":"New York" } }
```


**Значения в JSON могут быть массивами**

```
{ "employees": [ "John", "Anna", "Peter" ] }
```

**В JSON могут определяться логически значения true/false.**

```
{ "sale":true }
```

**В JSON могут определяться значения null.**

```
{ "middlename":null }
```

**JSON Schema**

https://json-schema.org/

## Нюансы

htmlspecialchars - Преобразует специальные символы в HTML-сущности

```php

$array = [
    'title' => 'Heading 1',
    'content' => '<h1>Heading "1" </h2> <p>«Hello word» & Hello word</p>'
];

$array2 = array_map(function($item){
	return addslashes($item);
}, $array);

$array3 = array_map(function($item){
	$item = str_replace('"', '\\"', $item);
	$item = str_replace('\'', "\u0027", $item);
	return $item;
}, $array);

$result = json_encode($array);
$result2 = htmlspecialchars(json_encode($array), ENT_QUOTES, 'UTF-8');
$result3 = json_encode($array2);


// {"title":"Heading 1","content":"<h1>Heading \&quot;1\&quot; <\/h2> <p>\u00abHello word\u00bb & Hello word<\/p>"}

// {&quot;title&quot;:&quot;Heading 1&quot;,&quot;content&quot;:&quot;&lt;h1&gt;Heading \&quot;1\&quot; &lt;\/h2&gt; &lt;p&gt;\u00abHello word\u00bb &amp; Hello word&lt;\/p&gt;&quot;}

// {"title":"Heading 1","content":"<h1>Heading \\\"1\\\" <\/h2> <p>\u00abHello word\u00bb & Hello word<\/p>"}
```

```html

<span data-json="<?php echo $result; ?>">
  Something
</span>

<script>
const json = document.querySelector('span').getAttribute('data-json');
const parsed = JSON.parse(json);
const parsed2 = JSON.parse('<?php echo $result3; ?>');
</script>

```

### Декодирование

```php

$encode = json_encode($array);
$decode = json_decode($encode); // Object
$decode = json_decode($encode, 1); // Assoc Array
```


# PHP

https://www.php.net/

**Вывести переменную**

```php

$array = [1,2,3,4]

echo 'hello world';
var_dump($array);
print_r($array); // Выводит удобочитаемую информацию о переменной

$n = 'Hello';
printf("%%s = '%s'", $n); // %s = 'Hello'

$a = 'Hello';
$b = 'World';

echo "{$a} {$b}";

echo 'hello' . ' ' . 'world';

str_repeat('Repeat', 3);

```

```python
print('hello' + ' ' + 'world')
print('Repeat' * 3)

# Repeat.__mul__(3)

```

**Условия**

```php

$x = 1;
if($x == 1) {
    echo 'x is 1';
}elseif($x == 2){

}else{

}

```

**Типы данных**


```php

$str = 'String';
$int = 6678;
$float = 345.66
$bool = true; // false

$array = [1,2,3,4,5];

$arrayAssoc = [
    'key1' => 'value1',
    'key2' => 'value2',
    'key3' => 'value3',
    'key4' => 'value4',
];

$emptyObjectInner = new stdClass();
$emptyObjectInner->lat = 55
$emptyObjectInner->lng = 55

$emptyObject = new stdClass();
$emptyObject->name = 'john';
$emptyObject->age = '22';
$emptyObject->inner = $emptyObjectInner;

$emptyObject2 = (object)[];

$toArray = json_decode(json_encode($emptyObject), true));
$toArray2 = (array)$emptyObject;

```


**Циклы**

```php

$lists = [0, 1, 2, 3, 4, 5];

foreach ($lists as $key => $list) {
    $list = $list * 2;
    echo "{$key} {$list}" . PHP_EOL;
}

foreach ($lists as $key => &$list) {
    $list = $list * 2;
}

for ($i = 1; $i <= 10; $i++) {
    echo $i;
}

```

## Примеры

```php

$x = 'Hello world';

// length
echo strlen($x);              // prints: 11

// character position
echo strpos($x, 'o');         // prints: 4

// counting occurrences
echo substr_count($x, 'l');   // prints: 3

// transforming
echo strtoupper($x);          // prints: hello world
echo strtolower($x);          // prints: HELLO WORLD

// splitting
print_r(explode(' ', $x));    // Prints: ['Hello', 'world']
echo count(explode(' ', $x)); // Prints: 2

echo str_contains($x, 'll'); // prints: true
echo str_starts_with($x, 'Hello');                // prints: true
echo str_ends_with($x, 'rld');                    // prints: true

$array = ['abc', 'add'];

$str = implode($array, ' ');

$mylist = [];
$mylist[] = 1;
$mylist[] = 'two';
$mylist[] = 3.0;


$a = $b = $c = [1];

$b[] = 2;
var_dump($a, $b, $c); // prints: [1] [1,2] [1]

$array = [1,2,3];

list($a, $b, $c) = $array;
[$a, $b, $c] = [1, 2, 3];

$input = array("a", "b", "c", "d", "e")
$output = array_slice($input, 2); // возвращает "c", "d" и "e"
$output = array_slice($input, -2, 1); // возвращает "d"
$output = array_slice($input, 0, 3);   // возвращает "a", "b" и "c"

$x = [1,2,3];

if (in_array(1, $x)) {
    echo '1 is in [1,2,3]';
}

$values = [1, 2, 3, 4, 5];

function sum($x) {
    return $x + 2;
}

$funcSum = function($x) {
    return $x + 2;
};

// $funcSum(6)

$doubled_values = array_map($funcSum, $values);

$doubled_values = array_map('sum', $values);

$doubled_values = array_map(function ($x) {
    return $x * 2;
}, $values);

$odd_values = array_filter($values, function ($x) {
    return $x % 2;
});

$doubled_values = array_map(fn($x) => $x + $y, $values);



$a = ['a' => 1, 'b' => 2, 'c' => 3];
$b = ['d' => 4, 'e' => 5, 'f' => 6];

$new = [...$a, ...$b];

$new = array_merge($a, $b);

$str1 = 1;
$str2 = '1';

$str1 == $str2;
$str1 === $str2;

echo is_int(123);                // True
echo is_float(3.14);             // True
echo is_string("John");          // True
echo is_array(["John", "Jane"]); // True

class Employee{};
$john = new Employee();

echo ($john instanceof Employee); // True

```

## Типизация

Какие определения типов могут использоваться при типизации:

- bool: допустимые значения true и false
- float: значение должно число с плавающей точкой
- int: значение должно представлять целое число
- string: значение должно представлять строку
- mixed: любое значение
- callable: значение должно представлять функцию
- array: значение должно представлять массив
- iterable: значение должно представлять массив или класс, который реализует интерфейс Traversable. Применяется при переборе в цикле foreach
- Имя класса: объект должен представлять данный класс или его производные классы
- Имя интерфейса: объект должен представлять класс, который реализует данный интерфейс
- Self: объект должен представлять тот же класс или его производный класс. Может использоваться только внутри класса.
- parent: объект должен представлять родительский класс данного класса. Может использоваться только внутри класса.


```php

declare(strict_types=1);

function sum(int $a, int $b): int
{
    return $a + $b;
}

function sum(ObjectSum $a, ObjectSum $b): int
{
    return $a->value + $b->value;
}

function sum(int|float $a, int $b): float
{
    return $a + $b;
}

```

## Классы

```php

namespace App\Services\Sms;

interface SmsSender
{
    public function send($number, $text): void;
}

// ------------

class ArraySender implements SmsSender
{
    private $messages = [];

    public function send($number, $text): void
    {
        $this->messages[] = [
            'to' => '+' . trim($number, '+'),
            'text' => $text
        ];
    }

    public function getMessages(): array
    {
        return $this->messages;
    }
}

class PostData
{
    public function __construct(
        public readonly string $title,
        public readonly string $body,
        public readonly DateTimeImmutable $publishedAt,
    ) {}
}

class PostData
{
    public function __construct(
        public string $title = 'title',
        public string $body = '',
        public DateTimeImmutable $publishedAt = new DateTimeImmutable,
    ) {}
}

class PersonData
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $fullName = '',
    ) {
        $this->fullName = $firstName . ' ' . $lastName;
    }
}


enum PostState
{
    case PENDING;
    case PUBLISHED;
    case STARRED;
    case DENIED;
}

enum PostState: string
{
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case STARRED = 'starred';
    case DENIED = 'denied';
}

enum VatPercentage: int
{
    case SIX = 6;
    case TWELVE = 12;
    case TWENTY_ONE = 21;
}

$value = PostState::PUBLISHED->value; // published
$value = VatPercentage::TWELVE->value; // 12
```

## Для работы с директориями и файлами

https://www.php.net/manual/ru/ref.dir.php

https://www.php.net/manual/ru/ref.filesystem.php


```php

$lines = file('file.txt', FILE_IGNORE_NEW_LINES);

foreach (glob("*.txt") as $filename) {
    $name = basename($filename);
    $dirname = dirname($filename);
    echo "$filename размер " . filesize($filename) . "\n";
}

$file = file_get_contents('people.txt');

file_put_contents('people.txt', 'text', FILE_APPEND );

$handle = fopen("file.txt", "r");

```

## Генераторы

```php

function getLines($file) {
    $f = fopen($file, 'r');
    try {
        while ($line = fgets($f)) {
            yield $line;
        }
    } finally {
        fclose($f);
    }
}

```
