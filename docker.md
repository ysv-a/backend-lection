# Виртуализация

## Виртуализация на уровне железа

![alt](https://i.gyazo.com/71f10c612aa410a192cbe1a12ff376df.png)

## Виртуализация на уровне ядра

(на уровне операционной системы - контейнер)

![alt](https://i.gyazo.com/5984ab50883af362be6eab13b0673603.png)


## Что контейнеры, что вир. машины - это все виртуализация:

Виртуализация появилась как средство уплотнения окружений на одном и том же железе. Сначала программный продукт выполнялся на железном сервере. Потом, чтобы иметь возможность поселять в одно и то же железо больше клиентов, чтобы максимально полно утилизировать производительные мощности, придумали виртуализацию. Теперь на одном и том же железе можно держать несколько окружений.

![alt](https://i.gyazo.com/6f52b42c351468a7950e256dd472c942.png)

# Виртуализация на уровне железа

![image info](/images/img1.png)

Гипервизор - или монитор виртуальных машин

В VM нельзя иметь ресурсов больше чем на хостовой системе

В VM полностью изолированное ядро, все библиотеки, строго ограниченные ресурсы по процессору и памяти.

Выделяем ресурсы

# Виртуализация на уровне ядра

![image info](/images/img2.jpg)

Container engine — это часть ПО, которое принимает пользовательские запросы, создает\ запускает контейнер.

Существует множество контейнерных движков, включая Docker, RKT, CRI-O и LXD.

Легковесная штука по сравнению с гипервизором практически нет оверхеда

Если в контейнере Linux, то и снаружи тоже Linux, на хост машине

Ограничиваем ресурсы

## Отличия

**Виртуальная машина:**

- Подразумевает виртуализацию железа для запуска гостевой ОС
- Может работать любая ОС
- Хорошо для изоляции

**Контейнер:**

- Использует ядро хостовой системы
- В контейнере только Linux (не давно и Windows)
- Контейнер для изоляции плохо - т.к можно выбраться на хостовую машину

# Рабочее окружение

Для разработки бекенда часто нужные все возможные сервисы, например:

- PHP
- Nginx(Apach) – сервер
- Mysql - бд
- PostgreSQL - бд
- MongoDB - NoSQL  бд
- Redis - NoSQL  бд
- Memcache - кэширования данных в оперативной памяти
- Nodejs
- RabbitMQ - брокер сообщений
- Mailer – почтовый сервер для тестирования почты
- ...

## Использование «шпаргалок»

Разработчик под каждый сервис пишет свою инструкции, как установить и как настроить
(файлы конфига и т.л)

Все сервисы устанавливаются на компьютере разработчика

Хорошо работает когда разработчик один

Минусы:

- Как поднять такое же окружение другому разработчику?
- Разные ОС
- Если разработка на Linux, то сложно поднять окружение на MacOs, Windows
- Как синхронно обновлять конфигурации сервисов и их настройки
- Разработка на разные устройствах(ноутбук, компьютер)
- Большое время воссоздания рабочего окружения
- Деплой

### Пример – установка сервиса MeiliSearch

```
1. echo "deb [trusted=yes] https://apt.fury.io/meilisearch/ /" | sudo tee /etc/apt/sources.list.d/meilisearch.list
2. sudo apt update
3. sudo apt install -y meilisearch-http

4. sudo nano /etc/systemd/system/meilisearch.service

[Unit]
Description=MeiliSearch search engine
After=network.target

[Service]
ExecStart=/usr/bin/meilisearch --http-addr 0.0.0.0:7700 --env production --master-key pwd123
Restart=always

[Install]
WantedBy=multi-user.target

5. sudo service meilisearch start
6. sudo systemctl enable meilisearch
```

## Разработка через виртуальные машины – виртуализация на уровне железа

Одна ОС, например ubuntu 18.04

Все инструкции и скрипты по установке ПО, запускались в вир. машине

- Настройки вир. машины (в ручную в большинстве случаев)
- Выделить кол. ядер,
- Выделить память,
- Настроить сети,
- Настроить сетевые папки
- И т.д

## Vagrant

Инструмент который позволяет  автоматизировать процесс создания и настройки вир. машин

Файл конфига Vagrantfile – все инструкции по установке образа и настройки виртуальной машины

```
vagrant up - запускалась вирт. машина - запускались скрипты - уст. сервисы и настраивались
vagrant halt - выключить
vagrant reload - перезагрузить машины
vagrant destroy - уничтожение машины
vagrant ssh - консоль вир. машины
```


```
# vagrant configurate
Vagrant.configure(2) do |config|
  # select the box
  config.vm.box = 'bento/ubuntu-18.04'

  # should we ask about box updates?
  config.vm.box_check_update = options['box_check_update']

  config.vm.provider 'virtualbox' do |vb|
    # machine cpus count
    vb.cpus = 1
    # machine memory size
    vb.memory = 1024
    # machine name (for VirtualBox UI)
    vb.name = Project1
  end


 # provisioners
  config.vm.provision 'shell', path: './vagrant/provision/once-as-root.sh', args: [options['timezone'], options['ip']]
  config.vm.provision 'shell', path: './vagrant/provision/once-as-vagrant.sh', args: [options['github_token']], privileged: false
  config.vm.provision 'shell', path: './vagrant/provision/always-as-root.sh', run: 'always'

  # post-install message (vagrant console)
  config.vm.post_up_message = "App URL: http://#{domains[:app]}"
```

## Пример VDS

![image info](/images/img3.jpg)

## Итого

Виртуализация на уровне железа: Оверхед на гипервизор, большой образ, медленно

![alt](https://i.gyazo.com/71f10c612aa410a192cbe1a12ff376df.png)

Виртуализация на уровне ядра (на уровне операционной системы): Большие образы, нет стандарта упаковки, проблема зависимости

![alt](https://i.gyazo.com/5984ab50883af362be6eab13b0673603.png)

## Пример LXC

LXC — системы контейнеров – виртуализация на уровне ядра

```
lxc launch ubuntu:18.04 web
lxc exec web -- apt update
lxc exec web -- apt install apache2
lxc exec web -- apt install php


lxc launch ubuntu:18.04 db
lxc exec db -- apt install -y mysql-server

lxc network attach my-network web eth0
```

# Переходим к докеру

- Меняет философию работы контейнеров
- 1 процесс - 1 контейнер
- Все зависимости в контейнере
- Чем меньше образ - тем лучше
- Инстансы становятся эфемерными - (недолговечными) - контейнер можно остановить и уничтожить, а затем перестроить
- Стандартизация упаковки приложения, приложение можно упаковать, отправить в репозиторий \ скачать, развернуть
- Гарантирует воспроизводимость, на люб. хостовых машинах
- Минимум или нет оверхеда
- Развертывание контейнеров Docker позволяет быстро и изолированно создавать несколько сред, включая среды, необходимые для вашего конвейера CI/CD, такие как среды сборки и тестирования

## Из чего состоит докер

![image info](/images/img4.jpg)

- Docker cli  - утилита по упр. докером - исп. для запуска команд – клиент
- Docker daemon - container engine – сервер
- Dockerfile -  инструкция как собирать образ
- Image – образы
- Container – контейнер который запускаются на основе образов

# Объекты 1ого класса докера

## Images

Images (образ) - доступный только для чтения шаблон который содержит набор инструкций для создания контейнера Docker - можно считать как класс

- Упаковка контейнера
- Из них запускается контейнеры
- Хранятся в докер реестрах (registry - docker hub)
- Имееют hash (sha256), имя и таг
- Имеет слоенную архитектуру
- Создаются по инструкциям dockerfile

## Containers

Containers  - работоспособный экземпляр или инстанс образа из которого он был создан.
Когда создается контейнер из образа, оба они становятся зависимыми др от др нельзя удалить образ, пока сущ. др контейнеры

- Запускается из образа
- Изолирован
- Должен содержать в себе все для работы приложения
- 1 процесс - 1 контейнер (но в практике не всегда)

# Образ

![image info](/images/img5.jpg)

Образы строятся из множества слоев, все размещаются др. над другом. Вместе они представляют единый объект

Каждый слой представляет собой отдельную инструкцию из докерафайла образа

Все слои доступы только для чтения, за иск. последнего

Каждый слой это набор отличий от слоя который был предыдущим

Когда создается контейнер он добавляет новый доступный для записи слой поверх всех др. слоев - это слой контейнера

Только инструкции RUN, COPY, ADD создают слои. Другие инструкции не увеличивают размер сборки.

## Пример

```
Dockerfile:

FROM phpmyadmin:latest
RUN apt-get -y install curl && rm -rf /var/lib/apt/lists/*

ENTRYPOINT [ "/docker-entrypoint.sh" ]
CMD ["apache2-foreground"]

docker build -t custom_phpmyadmin .

docker run --name container_phpmyadmin --rm -p 8080:80 custom_phpmyadmin

docker run --name container_phpmyadmin --rm -p 8081:80 phpmyadmin

```

![image info](/images/img6.jpg)

# Слой контейнера

Containers - работоспособный экземпляр или инстанс образа из которого он был создан.

Контейнер определяет лишь слой для записи\чтения наверху образа. Но не понятно запущен он или нет.

![image info](/images/img7.jpg)

![image info](/images/img8.png)

![image info](/images/img9.jpg)

## Определение запущенного контейнера

Запущенный контейнер — это «общий вид» контейнера для чтения-записи его изолированного пространства процессов.

![image info](/images/img10.jpg)

Процессы в пространстве контейнера могут изменять, удалять или создавать файлы, которые сохраняются в верхнем слое для записи.

![image info](/images/img11.jpg)

## Команды контейнера

docker create `<image-id>` (docker container create) - добавляет слой для записи наверх стека слоев, найденного по `<image-id>` (ex. phpmyadmin). Команда не запускает контейнер.

![image info](/images/img12.jpg)

![image info](/images/59972ee6b87c5900901ae946e40ba6dd.png)

docker start `<container-id>` (docker container start) - создает пространство процессов вокруг слоев контейнера. Может быть только одно пространство процессов на один контейнер.

![image info](/images/36a3b17c898bc8b2442a0d2a4052df64.png)

```
docker run === docker container run
-docker container create
-docker container start
```

docker stop(kill) `<container-id>` - Команда 'docker stop' посылает сигнал SIGTERM запущенному контейнеру, что мягко останавливает все процессы в пространстве процессов контейнера. В результате мы получаем не запущенный контейнер.

SIGTERM — сигнал, для запроса завершения процесса.

![image info](/images/2ea43ffcc2f6364127917078a073b270.png)

docker rm `<container-id>` - Команда 'docker rm' удаляет слой для записи, который определяет контейнер на хост-системе. Должна быть запущена на остановленном контейнерах. Удаляет файлы.

![image info](/images/ab4988c138cb4b5b475a3a55ad28f50b.png)

# Docker volumes

В Docker есть несколько способов хранения данных. Наиболее распространенные:

- тома хранения данных (docker volumes),
- монтирование каталогов с хоста (bind mount)

Тома — рекомендуемый разработчиками Docker способ хранения данных.

В Linux тома находятся по умолчанию в `/var/lib/docker/volumes/`

Window - `\\wsl$\docker-desktop-data\version-pack-data\community\docker\volumes`

![image info](/images/img13.jpg)

## Том (docker volumes)

Один том может быть примонтирован одновременно в несколько контейнеров. Когда никто не использует том, он не удаляется, а продолжает существовать.

**Для чего стоит использовать тома в Docker:**

- шаринг данных между несколькими запущенными контейнерами,
- решение проблемы привязки к ОС хоста,
- удалённое хранение данных,
- бэкап или миграция данных на другой хост с Docker (для этого надо остановить все контейнеры и скопировать содержимое из каталога тома в нужное место).

```
docker volume create my-storage
docker run -v my-storage:/var/lib/mysql mysql:8
(or --volume)
```

## Монтирование каталога с хоста (bind mount)

Используется, когда нужно пробросить в контейнер конфигурационные файлы с хоста.
Другое очевидное применение — в разработке. Код находится на хосте (вашем ноутбуке), но исполняется в контейнере.

```
docker run -v /user/project/database:/var/lib/mysql mysql:8
```

## Команды - Volume

```
Вывод списка всех томов на хосте:
docker volume ls

Создание тома:
docker volume create <NAME>

Инспектирование тома:
docker volume inspect <NAME>

Удаление тома:
docker volume rm <NAME>

Удаление всех неиспользуемых томов:
docker volume prune
```

## Когда использовать тома, а когда монтирование с хоста

![image info](/images/img14.png)

# Docker network

Подключает контейнер к сети. Подключить контейнер можно по имени или по ID. После подключения контейнер может взаимодействовать с другими контейнерами в той же сети.

```
Список сетей
docker network ls

Создание сети
docker network create <NAME>

Инспектирование сети
docker network inspect <NAME>

Удаление сети
docker network rm <NAME>
```

## Примеры команд

**Создание томов и сети**

```
docker volume create database_storage5
docker volume create mongodb_storage
docker network create somenet
```

**Создание контейнера phpmyadmin**

```
docker run -d --rm -p 8081:80 -e PMA_HOST=test-mysql --name test-phpmyadmin --net somenet phpmyadmin:latest
```

**Создание контейнера mysql**

```
docker run  --rm --name test-mysql  -e MYSQL_ROOT_PASSWORD=test -e MYSQL_DATABASE=test -e MYSQL_USER=test -e MYSQL_PASSWORD=test -v database_storage5:/var/lib/mysql  --net somenet -d  mysql:5.7
```

**Создание контейнера mondgodb**

```
docker run –d --rm --name test-mongodb -p 27017:27017 -e MONGO_INITDB_ROOT_USERNAME=mongo_user -e MONGO_INITDB_ROOT_PASSWORD=mongo_pass -v mongodb_storage:/data/db --net network_1 mongo
```

# Docker run

```
docker run [OPTIONS] IMAGE[:TAG|@DIGEST] [COMMAND] [ARG...]
```

**[OPTIONS]:**

- rm - автоматически удалять контейнер при его выключении
- name - задать имя контейнера
- volume, -v - привязать том
- detach,-d - запустить контейнер в фоновом режиме и распечать идентификатор контейнера
- env, -e - установить переменные окружения
- publish, -p - открыть порт контейнера на хосте
- tty,-t - Выделить псевдо-TTY, устройство которое имеет функции физического терминала
- interactive,-i - Держать STDIN (стандартный поток ввода) открытым, даже если он не подключен
- net - Подключить контейнер к сети

**IMAGE[:TAG|@DIGEST]:**

mysql , mysql:8 или mysql:latest или getmeili/meilisearch или ubuntu@sha256:82becede498899e,

**[COMMAND]: и [ARG...]**

Это команды, инструкции который будет выполнять контейнер, не обязательный параметр

Т.к команды могут быть встроены уже в Dockerfile

# Пример Dockerfile

```
VOLUME /var/lib/mysql

COPY docker-entrypoint.sh /usr/local/bin/
RUN ln -s usr/local/bin/docker-entrypoint.sh /entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 3306 33060
CMD ["mysqld"]

```

## Инструкция Dockerfile

Инструкция WORKDIR устанавливает рабочий каталог для любых RUN, CMD, ENTRYPOINT, COPY и ADD инструкции

```
FROM php:7.4-cli
WORKDIR app
COPY my_application.php /app/my_application.php
CMD ["php", "my_application.php"]


docker build -t testappphp .
docker run --rm testappphp

```

Инструкция RUN выполнит любые команды в новом слое поверх текущего образа и фиксирует результаты.

Инструкция COPY - копирует новые файлы или каталоги `<src>` и добавляет их в файловую систему контейнера по пути `<dest>`

Инструкция ADD - копирует новые файлы, каталоги или URL-адреса удаленных файлов `<src>` и добавляет их в файловую систему образа по пути `<dest>`.

Инструкция EXPOSE информирует Docker о том, что контейнер прослушивает указанные сетевые порты во время выполнения. Вы можете указать, прослушивает ли порт TCP или UDP, и по умолчанию используется TCP, если протокол не указан.

Инструкцию VOLUME следует использовать для предоставления доступа к любой области хранения базы данных, хранилищу конфигурации или файлам/папкам, созданным вашим докер контейнером.

## CMD и Entrypoint

**CMD**

Инструкция CMD позволяет установить команду по умолчанию, которая будет выполняться только тогда, когда запускается контейнер без указания команды.

Если контейнер Docker запускается с командой, команда по умолчанию будет игнорироваться. Если Dockerfile содержит более одной инструкции CMD, все инструкции CMD, кроме последней, игнорируются.

CMD — это инструкция, которую лучше всего использовать, если нужна команда по умолчанию, которую пользователи могут легко переопределить.

**ENTRYPOINT**

Инструкция ENTRYPOINT позволяет настроить контейнер, который будет работать как исполняемый файл. Он похож на CMD, потому что также позволяет указать команду с параметрами. Разница заключается в том, что команда ENTRYPOINT и параметры не игнорируются, когда контейнер Docker запускается с параметрами командной строки.

### Пример 1

```
Dockerfile:
FROM alpine
ENTRYPOINT ["ping"]
CMD ["www.google.com"]


docker build -t ping-service .
docker run --rm ping-service

docker run --rm ping-service ya.ru
```

### Пример 2

```
Dockerfile:
FROM alpine
CMD ["ping", "www.google.com"]

docker build -t ping-service2 .
docker run --rm ping-service2

docker run --rm ping-service2 ping ya.ru

```

## Переопределение CMD и ENTRYPOINT

CMD или ENTRYPOINT установлены в родительском образе, ни один из них не установлен в дочернем образе - докер сохранит родительский.

CMD и ENTRYPOINT устанавливаются в родительском образе, как и в дочернем — docker  переопределит оба

ENTRYPOINT установлен в родительском образе, CMD  представлен в дочернем образе - докер  сохранит оба

CMD установлен в родительском образе, ENTRYPOINT представлен в дочернем образе - докер  сохранит ENTRYPOINT, но CMD будет сброшен

# Команды

```

Список запущенных контейнеров
docker ps
docker ps -a  (все контейнеры в том числе и остановленные)

Создать контейнер и присоединиться к нему:
docker run -it busybox

Создать контейнер и запустить его в фоне:
docker run -d nginx

Создать контейнер с именем и запустить его в фоне:
docker run -d -name container_alpine alpine

(ps. docker run === docker container run)

Выполнить команду в контейнере:
docker container exec -it container_alpine ping ya.ru

Отобразить информацию, собранную запущенным контейнером (логирование)
docker container logs container_alpine

Инспектирование процессов в контейнере
docker container top container_alpine

Отображение статистики использования ресурсов контейнеров в реальном времени.
docker stats container_alpine


Остановка контейнера
docker stop container_alpine
docker kill container_alpine

Удаление контейнера
docker rm container_alpine

Остановить все Docker контейнеры.
docker stop $(docker ps -a -q)
docker kill $(docker ps -q)

Удалить все Docker контейнеры
docker rm $(docker ps -a -q)

Удаление всех неиспользуемых контейнеров, сетей, образов и томов
docker system prune


```

# Docker Compose

Инструмент для описание и запусков приложения которые состоят из нескольких приложений

Docker Compose утилита позволяет запускать проект состоящий из нескольких контейнеров:

- Позволяет запустить и настроить много контейнерные приложения
- Все описывается в docker-compose.yml
- Создает свою сеть проекту
- Дает возможность обращаться контейнерам др к др по именам

## Команды

```
docker-compose build  собрать проект

docker-compose up -d  запустить проект (запускать в режиме демона)

docker-compose down  остановить проект

docker-compose logs -f [service name] посмотреть логи сервиса

docker-compose ps  вывести список контейнеров

docker-compose exec [service name] [command] выполнить команду

docker-compose images  список образов
```

## RESTART

**on-failure:on-failure[:max-retries]**

Перезапускает контейнер, если он завершает работу из-за ошибки, которая проявляется как ненулевой код выхода. Можно ограничить количество попыток демона Docker перезапустить контейнер с помощью :max-retries параметра.

**always**

Контейнер будет перезапускается всегда, даже если был остановлен.

Всегда перезапускается контейнер, если он останавливается. Если он остановлен вручную, он перезапускается только при перезапуске демона Docker или при ручном перезапуске самого контейнера.

**unless-stopped**

Аналогичен always, за исключением того, что когда контейнер останавливается (вручную или иным образом), он не перезапускается даже после перезапуска демона Docker.

# Для ознакомления

https://www.youtube.com/watch?v=QF4ZF857m44

https://12factor.net/ru/

https://habr.com/ru/company/southbridge/blog/530226/

https://habr.com/ru/company/southbridge/blog/329138/

https://habr.com/ru/post/349802/
