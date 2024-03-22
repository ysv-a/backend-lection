# ORM

Object Relational Mapping (объектно-реляционное отображение), обычно упоминающееся как аббревиатура ORM, это техника, соединяющая сложные объекты приложения с таблицами в системе управления реляционными базами данных. С помощью ORM, свойства и взаимоотношения этих объектов приложения могут быть с легкостью сохранены и получены из базы данных без непосредственного написания выражений SQL, и, в итоге, с меньшим суммарным кодом для доступа в базу данных.

# Паттерны для работы с бд и ORM

## Active record

Eloquent и DjangoORM является реализацией шаблона Active Record.

Данный шаблон берет на себя две ответственности: первая — сущность (например, пользователь, заказ, проект и т.д.) и вторая — взаимодействие с хранилищем данных (простыми словами, он умеет себя доставать из БД, обновлять и удалять).

Класс User, наследуясь от Model, наследует огромный пласт кода, который работает с базой данных и сам становится навеки связанным с ней. Связь объектов с базой данных жесткая и неразрывная.


**Минусы:**

- Модели Active Record нарушают принципы SOLID.
- Реализации сохранения данных тесно связана с бизнес-логикой
- Связь объектов с базой данных жесткая и неразрывная
- Сложно тестировать

**Плюсы:**

- Быстрая разработка, RAD
- Простота работы со связями (relations)

## Data mapper

(Doctrine и SQLAlchemy)

Шаблон проектирования Data Mapper является прослойкой между сущностью и хранилищем данных. Он служит для облегчения сущности путем взятия на себя ответственности по работе с хранилищем данных. Другими словами, при использовании Data Mapper сущность (пользователь, заказ, проект и т.д.) работает только со своими данными и бизнес-логикой, а сохранять, обновлять и удалять её будет другая часть системы.

Использование Data Mapper позволяет облегчить модель и отдать обязанности другим частям системы, это обеспечит более простую поддержку бизнес-логики и её тестирование. Но ценой этому является усложнение и увеличение приложения, нужно будет писать больше кода.

Когда разработчик хочет сохранить состояние сущности в базе данных, он вызывает метод persist у Data Mapper библиотеки и она, используя некоторую мета-информацию про то, как именно нужно хранить эту сущность в базе данных, обеспечивает их маппинг в базу данных и обратно.

**Плюс:**

- Каждый объект имеет свою зону ответственности, тем самым следуя принципам SOLID и сохраняя каждый объект простым и по существу.
- Бизнес-логика и сохранение данных связаны слабо
- Тестирование

**Минусы:**

- Код намного более сложный, чем код Eloquent
- Сложные запросы


## Выбор ORM

Active Record - чаcть RAD (rapid application development - быстрая разработка приложений), и цель его быстро развернуть уровень доменных моделей (бизнес логики) по существующей схеме базы.

Если проект большой, много сложных сущностей с большим количеством логики, можно брать DataMapper - Code First или когда сначало нужно описать бизнес-логику, а потом уже думать над тем как её сохранить в подходящих хранилищах.

Это разные ORM, написанные с разными целями.

# Databases. Configuration - Laravel

```

php artisan make:model Post
php artisan make:model Post -m

php artisan make:model Post -m -r -f
-m - создает миграцию
-r - создает контролер с CRUD методами
-f - создание фабрики

public $timestamps = false; - отключить created_at, updated_at
protected $table = 'my_products';
protected $connection = 'connection-name'; // sqlite
protected $fillable = ['name', 'price']; // Атрибуты, для которых разрешено массовое присвоение значений.
protected $guarded = []; //  Атрибуты, для которых НЕ разрешено массовое присвоение значений.
protected $hidden = ['password']; // Атрибуты, которые должны быть скрыты из массивов.
protected $casts = ['admin' => 'boolean']

https://laravel.su/docs/10.x/eloquent

https://laravel.su/docs/10.x/eloquent-mutators#attribute-casting

```

# Отношения

## Один к одному - Laravel



```

users
    id - integer
    name - string

phones
    id - integer
    user_id - integer
    number - string

```

```php

class User extends Model
{
    public function phone()
    {
        return $this->hasOne(Phone::class, 'user_id', 'id');
    }
}
class Phone extends Model // user_id
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
        //return $this->belongsTo(User::class, 'foreign_key');
    }
}

$user = User::find(1)
$user->phone
$phone = Phone::find(1)
$phone->user


```

## Django

```
class Phone(models.Model):
    number = models.CharField(max_length=20)

class User(models.Model):
    phone = models.OneToOneField(Phone, on_delete=models.CASCADE)


Прямые

user = User.objects.get(id=1)
user.phone

Обратные отношения

phone = Phone.objects.get(id=5)
phone.user
```

## Один ко многим

```
posts
    id - integer
    category_id
    name - string

category
    id - integer
    name - string
```

### Laravel

```php

class Post extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);

    }
}
class Category extends Model
{

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

$category = Category::find(1);
$posts = $category->posts()->get();


$post = Post::find(1);
$category = $post->category;
```

### Django

```py
class Category(models.Model):
    name = models.CharField(max_length=200)

class Post(models.Model):
    category = models.ForeignKey(Category, on_delete=models.CASCADE)

```

**Прямые**

Если модель имеет ForeignKey, экземпляры этой модели будут иметь доступ к связанному (чужому) объекту через простой атрибут модели.

```
p = Post.objects.get(id=1)
p.category
```

**Обратные отношения**

Для получения коллекции по связаной записи, к имени модели добавляется _set

```
c = Category.objects.get(id=1)
posts_by_category = c.post_set.all()

c.post_set.filter(name__contains='Python')
c.post_set.count()
```

## Многие ко многим

```
users
    id - integer
    name - string

roles
    id - integer
    name - string

role_user
    user_id - integer
    role_id - integer
```

```php

class User extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

$user = User::find(1);
$roles = $user->roles

$role = Role::find(1);
$user = $role->users

```

### Django

Одно из различий заключается в именовании атрибутов: модель, которая определяет ManyToManyField, использует имя атрибута самого поля, тогда как «обратная» модель использует имя модели в нижнем регистре исходной модели, плюс '_set' (точно так же, как обратные отношения один ко многим)

```py
class Tag(models.Model):
    name = models.CharField(max_length=100)

class Post(models.Model):
    tags = models.ManyToManyField(Tag, empty_label=None)
```

```
p1 = Post.objects.get(id=1)
p2 = Post.objects.get(id=2)

tag = Tag(name="Example")
tag.save()
tag.post_set.add(p1, p2)

p3 = Post.objects.get(id=3)
p3.tags.add(tag)
```



# CRUD ActiveRecord

https://django.fun/docs/django/5.0/topics/db/

https://django.fun/docs/django/5.0/ref/models/

https://django.fun/docs/django/5.0/ref/models/fields/

https://django.fun/docs/django/5.0/ref/models/querysets/

https://django.fun/docs/django/5.0/topics/db/queries/

F и Q объекты

## Django - READ

```
Category.objects.all()

SQL: SELECT * FROM category

Использование сокращения pk - поиск по идентификатору
Post.objects.get(id__exact=14) # Explicit form
Post.objects.get(id=14) # __exact is implied
Post.objects.get(pk=14) # pk implies id__exact


Post.objects.filter(pk__in=[1,4,7])
Post.objects.filter(pk__gt=14)

Post.objects.filter(category__id__exact=3) # Explicit form
Post.objects.filter(category__id=3)        # __exact is implied
Post.objects.filter(category__pk=3)        # __pk implies __id__exact

```

filter(**kwargs) - Возвращает новый QuerySet, содержащий объекты, которые соответствуют заданным параметрам поиска.

exclude(**kwargs) - Возвращает новый QuerySet, содержащий объекты, которые не соответствуют указанным параметрам поиска.

**Сокращения для фильтров**

```
in [10, 20, 30] - WHERE IN
gt >
lt <
lte <=
gte >=
__exact =
__startswith
__endswith
__contains
```

```
Post.objects.filter(name__startswith="What", category__id=2)
Post.objects.filter(name__endswith="What", category__id=2)
Post.objects.filter(name__exact="What", category__id=2)
Post.objects.filter(name="What", category__id=2)
Post.objects.filter(name__contains="What", category__id=2)
Post.objects.filter(pub_date__lte='2006-01-01')



SELECT * FROM post WHERE category_id = 2 AND name LIKE 'What%'
SELECT * FROM post WHERE category_id = 2 AND name LIKE '%What'
SELECT * FROM post WHERE category_id = 2 AND name = 'What'
SELECT * FROM post WHERE category_id = 2 AND name LIKE '%What%'
SELECT * FROM post WHERE pub_date <= '2006-01-01';

Post.objects.filter(pub_date__year=2006)
Post.objects.filter(category__name='Python')
Category.objects.filter(post__name__contains='Python')

```

## Django - CREATE:

```

category = Category(name="Python")
category.save()
category.id // 1

category = Category()
category.name = 'C#'
category.save()
category.id // 2

SQL: INSERT INTO Group ('name') VALUES ('Python')

```

## Django - UPDATE:

```
category = Category.objects.get(id=14)
category.category_name = "Python Update"
category.save()

SQL: UPDATE category SET name='Python Update' WHERE id=14

Post.objects.filter(pub_date__year=2023).update(post_name='Everything is the same')

```

## Django - DELETE:

```
category = Category.objects.get(id=14)
category.delete()

SQL: DELETE FROM category WHERE id = 1
```

## laravel - CREATE:

```
$car = new Car;
$car->name = "Машина 1 модель 5";
$car->save();

raw: INSERT INTO cars ('name')
VALUES ('Новое название')

```

## laravel - READ

```

$car = Car::find(1);

$car = Car::where('active', true)->first();
$cars = Car::where('active', true)->get();
$cars = Car::where('id', 1)->get();
$car = Car::where('id', 1)->firfst();
$cars = Car::where('id', 1)->where('name', 'Имя машины')->where('brand', 'brand')->get();
$cars = Car::all();

$cars = Car::where('active', true)->select('name', 'brand')->get();

raw: SELECT * FROM cars
raw: SELECT * FROM cars WHERE id = 1 AND name = 'Имя машины'

```

## laravel - UPDATE:

```
$car = Car::find(1);
$car->name = "Машина 1 модель 6";
$car->save();

raw: UPDATE cars SET name='Машина 1 модель 6' WHERE id=1
```

## laravel - DELETE:

```

$car = Car::find(1);
$car->delete();

raw: DELETE FROM cars WHERE id = 1

```


# CRUD QueryBuilder:

Query Builder - конструктор запросов - предоставляет удобный, выразительный интерфейс для создания и выполнения запросов к базе данных. Он может использоваться для выполнения большинства типов операций и работает со всеми подерживаемыми СУБД.

## CREATE:

```php

DB::table('users')->insert([
    ['email' => 'picard@example.com', 'votes' => 0],
    ['email' => 'janeway@example.com', 'votes' => 0],
]);

```

## READ:

```php

$users = DB::table('users')->get();
$user = DB::table('users')->where('name', 'John')->first();
$user = DB::table('users')->find(3); // ->where('id', 3)->first();

$users = DB::table('users')
            ->select('name', 'email as user_email')
            ->get();

$users = DB::table('users')
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->orderBy('users.name', 'desc')
            ->get();

```

## UPDATE:

```php
DB::table('users')->where('id', 1)->update(['votes' => 1]);
```

## DELETE:

```php
$deleted = DB::table('users')->delete();
$deleted = DB::table('users')->where('votes', '>', 100)->delete();
```

# RAW SQL

Используются когда ORM или QB ограничивают разработчика

Когда работаем с raw sql, нужно не забывать про sql иньекции, нужно очищать данные которые приходят из вне

```php

DB::select("UPDATE cars SET name='Обновленное название' WHERE id=1")

$price = $_POST['price']; // 1.0825
DB::table('orders')->selectRaw('price * ? as price_with_tax', [$price])->get();

$orders = DB::table('orders')->whereRaw('price > IF(state = "TX", ?, 100)', [200])->get();

```

https://django.fun/docs/django/5.0/topics/db/sql/

# Миграции

Миграции — системы контроля версий для вашей базы данных.

```

php artisan make:migration create_users_table --create=users
php artisan make:migration add_votes_to_users_table --table=users // update_users_table
php artisan migrate - накатить миграции
php artisan migrate:rollback --step=5 - откатить последние миграции
php artisan migrate:reset - откатить все миграции
php artisan migrate:refresh - откатить все миграции и заново накатить
php artisan migrate:refresh --seed  - Обновляем базу данных и запускаем все наполнители базы данных

```

```

+-------------------+---------------------------------------+---------------------+---------------------------------+
|        Что        |                Правило                |       Принято       |           Не принято            |
+-------------------+---------------------------------------+---------------------+---------------------------------+
| Таблица           | мн.число                              | article_comments    | article_comment,articleComments |
| Pivot таблица     | имена моделей в алф.порядке, в ед.ч.  | article_user        | user_article                    |
| Столбец в таблице | snake_case без имени модели           | meta_title          | metaTitle,MetaTitle             |
| Свойство в модели | snake_case                            | $model->meta_title  | metaTitle,MetaTitle             |
| Внешний ключ      | имя модели ед.ч. и _id                | article_id          | id_article                      |
| Первичный ключ    | -                                     | id                  | custom                          |
+-------------------+---------------------------------------+---------------------+---------------------------------+

```

указаны все типы колонок для миграций:

https://laravel.su/docs/10.x/migrations#columns

```

->nullable();
->default();
->unique(); создание индекса
->unsigned(); без знаковое

```

## Django

```
python manage.py makemigrations - анализ моделей и создание миграции
python manage.py migrate - перенос миграции в бд
python manage.py migrate example_app zero - откат миграции
в 1ом аргументе указывается название приложения, во 2ом номер миграции или zero(0)
```

## Опции полей

blank - Если True, поле может быть пустым. По умолчанию установлено значение False.
Если поле имеет blank=True, проверка формы позволит ввести пустое значение. Если поле имеет blank=False, поле будет обязательным.

null - Если True, Django будет хранить пустые значения как NULL в базе данных. По умолчанию установлено значение False

default - Значение по умолчанию для поля.

unique - Если указано True, это поле должно быть уникальным во всей таблице.

verbose_name - Удобочитаемое имя для поля.

choices - Последовательность, состоящая из итераций ровно двух элементов

## Типы полей

BooleanField

BinaryField - Поле для хранения необработанных двоичных данных.

CharField - Строковое поле, для строк малого и большого размера

TextField - Большое текстовое поле.

DateField - Дата, представленная в Python экземпляром datetime.date.

DateTimeField - Дата и время, представленные в Python экземпляром datetime.datetime.

DecimalField - Десятичное число с фиксированной точностью, представленное в Python экземпляром Decimal. models.DecimalField(..., max_digits=5, decimal_places=2) - 999.99

EmailField

FloatField

IntegerField \ PositiveIntegerField


## Ограничения внешнего ключа:

Ограничения целостности базы данных

Ссылочная целостность, post не может быть создан без категории, если при создании поста, указываем не сущ. Id категорию, то будет ошибка (Cannot add or update a child row: a foreign key constraint fails)

Без внешних ключей ссылочную целостность обеспечивает приложение. Таким образом, если в приложении что-то пошло не так, вы можете получить странные данные в БД (например, заказы для несуществующего пользователя).

ForeignKey.on_delete

При удалении объекта, на который ссылается ForeignKey, Django будет эмулировать поведение ограничения SQL, заданного аргументом on_delete. Например, если у вас есть обнуляемым ForeignKey и вы хотите, чтобы он был установлен в null, когда ссылочный объект удален

Возможные значения для on_delete:

CASCADE - Каскадное удаление. Django эмулирует поведение ограничения SQL ON DELETE CASCADE, а также удаляет объект, содержащий ForeignKey.

PROTECT - Предотвращает удаление объекта, на который есть ссылка, путем вызова ProtectedError, подкласса django.db.IntegrityError.

RESTRICT - Предотвращает удаление указанного объекта путем вызова RestrictedError (подкласс django.db.IntegrityError). В отличие от PROTECT, удаление ссылочного объекта допускается, если он также ссылается на другой объект, который удаляется в той же операции, но через отношение CASCADE.

SET_NULL - Устанавливает ForeignKey null; это возможно только в том случае, если null равно True.

SET_DEFAULT - Устанавливает для ForeignKey значение по умолчанию; значение по умолчанию для ForeignKey должно быть указано в описании поля.

DO_NOTHING - Не предпринимает никаких действий. Если ваша база данных обеспечивает ссылочную целостность, это вызовет IntegrityError, если вы вручную не добавите ограничение SQL ON DELETE в поле базы данных.

### Laravel

**ON DELETE RESTRICT**

означает, что если попробовать удалить категорию, у которой в таблице посты есть данные, БД не даст этого сделать: Cannot delete or update a parent row: a foreign key constraint fails

**ON DELETE CASCADE**

при удалении категории, удаляются, блог посты

**ON UPDATE CASCADE**

если изменится id категории, то в постах авт. изменится category_id

**ON UPDATE RESTRICT**

## Индексы

Индекс – это отсортированный набор значений.

```php

$table->primary('id');	//Добавить первичный ключ.
$table->primary(['id', 'parent_id']);	//Добавить составной ключ.
$table->unique('email');	//Добавить уникальный индекс.
$table->index('state');	//Добавляет простой индекс.
$table->fulltext('body');	//Добавляет полнотекстовый индекс.
```

https://django.fun/docs/django/5.0/ref/models/options/

https://django.fun/docs/django/5.0/ref/models/indexes/


```py

class Customer(models.Model):
    first_name = models.CharField(max_length=100)
    last_name = models.CharField(max_length=100)

    class Meta:
        indexes = [
            models.Index(fields=["last_name", "first_name"]),
            models.Index(fields=["first_name"], name="first_name_idx"),
        ]

```


## N+1

select_related - когда получаем доступ по связи через свойства указанные в модели (когда получаем не коллекцию)

prefetch_related - когда получаем коллекцию

https://django-debug-toolbar.readthedocs.io/en/latest/installation.html


## Seeding

Seeding - простой механизм наполнения вашей БД начальными данными с помощью специальных классов, которые хранятся в директории database/factories. Создать seeder можно командой:

```

php artisan make:factory PostFactory
php artisan db:seed // запустить загрузку данных
php artisan migrate:refresh --seed // откатить миграции и запустить загрузку

```

https://fakerphp.github.io/formatters/date-and-time/

https://laravel.su/docs/10.x/database-testing#defining-model-factories

### Django

https://pypi.org/project/django-seeding/

https://faker.readthedocs.io/en/master/

## Soft Delete

is_active

https://laravel.com/docs/10.x/eloquent#soft-deleting

## Транзакция

Транзакция представляет собой группу запросов SQL, обрабатываемых атомарно, то есть как единое целое. Если подсистема базы данных может выполнить всю группу запросов, она делает это, но если какой-либо запрос не может быть выполнен в результате сбоя или по иной причине, ни один запрос группы не будет выполнен.

Вы начинаете транзакцию командой START TRANSACTION, а затем либо сохраняете изменения командой COMMIT, либо отменяете их командой ROLLBACK.

```

mysql:
START TRANSACTION;
SELECT balance FROM checking WHERE customer_id = 10233276;
UPDATE checking SET balance = balance - 200.00 WHERE customer_id = 10233276;
UPDATE savings SET balance = balance + 200.00 WHERE customer_id = 10233276;
COMMIT;


```

```php

DB::beginTransaction();
DB::rollBack();
DB::commit();

```

## Django

https://django.fun/docs/django/5.0/topics/db/transactions/


# locking

Когда в системе, один объект могут править одновременно несколько пользователей

Pessimistic locking - это подход, при котором блокировка ресурса устанавливается на всё время, пока этот ресурс используется. (вероятность выше)

Optimistic locking, наоборот, не блокирует ресурс, пока он доступен для работы другим потокам. Вместо этого каждый поток получает версию данных в начале операции. После того, как операция выполнена, данные сохраняются только в том случае, если версия данных не была изменена другим потоком за время выполнения операции. (вероятность ниже)

# DataMapper - codeFirst

```php

use Doctrine\ORM\Mapping as ORM;
class Car
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    public function setName(): string
    {
        return $this->name;
    }
    // ... getter and setter methods
}

```

```
php bin/console make:migration
migrations/Version20211116204726.php
```

## CREATE:

```

$entityManager = (new ManagerRegistry)->getManager();
объект диспетчера сущностей Doctrine, он отвечает за сохранение объектов в базе данных и выборку объектов из базы данных.
$car = new Car;
$car->setName('Новое название')

$entityManager->persist($car); // говорим doctrine о том что сохранится объект, sql не выполняется
$entityManager->flush(); // doctrine просматривает все объекты, которыми он управляет, чтобы определить, нужно ли их сохранять в базе данных.

```

## READ

```php

$repository = (new ManagerRegistry)->getRepository(Car::class)
$car = $repository->find($id);
$cars = $repository->findAll();

```

## UPDATE

```php


$entityManager = (new ManagerRegistry)->getManager();
$repository = $entityManager->getRepository(Car::class)
$car = $repository->find($id);
$car->setName('New product name!');
$entityManager->persist($car);
$entityManager->flush();

```

## DELETE

```php
$entityManager->remove($car);
$entityManager->flush();
```

# Misc

https://postgrespro.ru/education/books/dbtech

https://stepik.org/course/63054/promo

https://postgrespro.ru/education/books/internals

# Примеры структур таблиц
