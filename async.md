# Что такое асинхронность и синхронность

## асинхронность

Асинхронное программирование — это способ организации кооперативной работы программы, который повышает производительность и улучшает использование ресурсов. Полезно в случаях, когда программе необходимо обрабатывать многочисленные операции ввода-вывода (I/O), занимающие значительное количество времени.

Асинхронное программирование — это подход к написанию кода, при котором несколько задач выполняются параллельно и независимо друг от друга.

## синхронность

Каждая операция выполняется последовательно и синхронно.


# В каких задачах лучше использовать асинхронное программирование



## I/O-Bound Process

Приложение проводит большую часть времени, общаясь с медленным устройством, например с сетевым подключением, жестким диском или принтером. Для ускорения процесса необходимо перекрыть время ожидания этих устройств.

Задачи, в которых асинхронный подход наиболее эффективен, называются I/O-bound задачами. I/O означает «ввод/вывод», а bound переводится как «ограничение». Это задачи, время выполнения которых в основном определяется временем выполнения всех операций ввода/вывода, таких как работа с сетью и файловой системой.

Асинхронный подход оптимизирует не время выполнения отдельных операций ввода/вывода, а общее время работы программы, которая обычно состоит из множества таких операций.

Асинхронное программирование позволяет веб-серверу обрабатывать множество запросов одновременно, не ожидая завершения текущего запроса перед переходом к следующему.

Для IO bound программ, можно использовать асинхронность (конкурентность), чтобы ускорить процесс ввода/вывода.

Задачи, связанные с вводом-выводом, не ограничены количеством физических ядер ЦП.

## CPU-Bound Process

Приложение проводит большую часть своего времени, выполняя операции ЦП. Для его ускорения необходимо найти способы выполнить больше вычислений за тот же промежуток времени. Вычислительные задачи, которые полностью ограничены быстродействием
процессора, а не ожиданием внешних ресурсов.

Для CPU bound программ, можно использовать многопроцессорные системы, чтобы улучшить производительность.

## Итого

Программы, ориентированные на ввод-вывод, — это программы, которые проводят большую часть своего времени в ожидании чего-то, в то время как программы, ориентированные на процессор, тратят свое время на обработку данных или вычисление чисел так быстро, как только могут.

Асинхронный подход требует планировщика, например event loop. В CPU-bound операциях этот компонент бесполезен, но при этом
всё равно тратит время на свою работу.

# Многопоточноть(multithreading) и многопроцессорность(multiprocessing)

## Многопроцессорность - параллелизм

(multiprocessing-Pool,concurrent.futures-ProcessPoolExecutor)

Это возможность одновременного выполнения нескольких задач на нескольких ядрах ЦП.

Обеспечивает высокий уровень изоляции ресурсов и согласованности данных за счет дорогостоящей сериализации данных.
Высокая стоимость сериализации данных означает, что параллелизм на основе процессов начинает разрушаться, когда вам приходится передавать большие объёмы данных между вашими рабочими процессами.

В контексте Python, параллелизм обычно достигается через модуль multiprocessing , который позволяет создавать отдельные процессы для параллельного выполнения задач.

![alt](https://files.realpython.com/media/parallel.bcf05cc11397.png)

## Многопоточноть(multithreading)

(Thread,ThreadPoolExecutor|threading|concurrent.futures - concurrent),

Concurrency - это возможность одновременного выполнения нескольких задач на ЦП. Задачи могут запускаться, выполняться и завершаться в перекрывающиеся периоды времени. В случае одного процессора несколько задач выполняются с помощью переключения контекста, при котором состояние процесса сохраняется, чтобы его можно было вызвать и выполнить позже.
В Python, конкурентность может быть достигнута с помощью threading.

Потоки более легкие и создаются быстрее, чем процессы. Они используют общую область памяти, что делает сериализацию ненужной и удешевляет обмен данными.

Поток, это компонент процесса.

Несколько потоков процесса могут выполняться одновременно (благодаря возможностям многопоточности), совместно используя ресурсы, такие как память, в то время как разные процессы не используют эти ресурсы совместно.

Переключение контекста делает возможной многозадачность на одноядерных архитектурах. Однако многоядерные процессоры также получают выгоду от этого метода, когда количество задач превышает доступную вычислительную мощность, что часто бывает. Следовательно, Concurrency обычно предполагает распределение отдельных фрагментов задачи по множеству ЦП, сочетая возможности переключения контекста и параллельной обработки. (в питоне идеально не работает из-за GIL)

Используется вытесняющая многозадачность.
Вытесняющая многозадачность - предполагает использование механизма прерываний, который приостанавливает текущий процесс и вызывает планировщик, чтобы определить, какой процесс должен выполняться следующим. Таким образом, все процессы будут получать определенное количество процессорного времени в любой момент времени.

![alt](https://files.realpython.com/media/concurrent.f333207efd07.png)

Переключение контекста между несколькими задачами. Выполняющаяся в данный момент задача может добровольно приостановить свое выполнение или быть принудительно приостановлена, чтобы передать часть процессорного времени другой задаче.

Медленные вещи, с которыми ваша программа будет взаимодействовать чаще всего, — это файловая система и сетевые подключения.

![alt](https://files.realpython.com/media/IOBound.4810a888b457.png)

Пример многопоточности threading:

![alt](https://files.realpython.com/media/Threading.3eef48da829e.png)

Используется несколько потоков для одновременной отправки нескольких запросов к веб-сайтам.

## Корутины - asyncio concurrent (via coroutines) (multithreading)

В Python, корутины может быть достигнуты с помощью, asyncio.

Корутины это более лёгкие единицы выполнения, чем потоки. В отличие от потоков и процессов, им не требуется упреждающий планировщик задач (вытесняющая многозадачность), поскольку они используют кооперативную многозадачность, добровольно приостанавливая свое выполнение в определенных точках.

Пример многопоточности asyncio

![alt](https://files.realpython.com/media/Asyncio.31182d3731cf.png)

Цикл событий, контролирует, как и когда запускается каждая задача. Цикл событий знает о каждой задаче и знает, в каком состоянии она находится.

## Итого

Процесс — это экземпляр программы, выполняемой на компьютере.

Поток — это единица выполнения внутри процесса.

Когда у программы несколько процессов, это называется мультпроцессингом. Если у программы несколько потоков, это называется многопоточностью.

Все программы выполняют два типа задач: связанные с вводом-выводом (I/O-bound) или связанные с процессором (CPU-bound).

Процессы, связанные с вводом/выводом, тратят больше времени на ввод/вывод, чем на вычисления. Примеры: сетевые запросы, соединения с базами данных, ввод/вывод файлов.

Процессы, привязанные к процессору, тратят больше времени на вычисления, чем на запросы ввода-вывода. Примеры: умножение матриц, поиск простых чисел, сжатие видео, потоковое видео.

Технически, многопоточность подходит для процессов, связанных с вводом/выводом, а многопроцессорность — для процессов, связанных с процессором.

Решение проблем в python:

I/O-Bound Process = Многопоточноть. ThreadPoolExecutor, asyncio
CPU-Bound Process = Многопроцессорность. ProcessPoolExecutor

```
Вытесняющая многозадачность (threading)
Операционная система решает, когда переключать задачи, внешние по отношению к Python.
Кол-во процессов 1

Кооперативная многозадачность (asyncio)
Задачи решают, когда следует отказаться от контроля.
Кол-во процессов 1

Многопроцессорность (multiprocessing)
Все процессы выполняются одновременно на разных процессорах.
Кол-во процессов: много

```

В threading операционная система фактически знает о каждом потоке и может прервать его в любой момент, чтобы запустить другой поток. Это называется вытесняющей многозадачностью, поскольку операционная система может вытеснить ваш поток для переключения.
Вытесняющая многозадачность удобна тем, что коду в потоке не нужно ничего делать для переключения.

Asyncio, с другой стороны, использует кооперативную многозадачность. Задачи должны сотрудничать, оповещая, о том, когда они готовы к преключению.

С помощью multiprocessing python создает новые процессы. Процесс можно рассматривать как почти совершенно другую программу, хотя технически он обычно определяется как набор ресурсов, включающий в себя память, дескрипторы файлов и тому подобное.

## Потоки против процессов

Потоки отличаются от традиционных многозадачных процессов операционной системы по нескольким причинам:

- процессы обычно независимы, а потоки существуют как подмножества процесса
- процессы переносят значительно больше информации о состоянии, чем потоки, тогда как несколько потоков внутри процесса совместно используют состояние процесса, а также память и другие ресурсы.
- процессы имеют отдельные адресные пространства, тогда как потоки разделяют свое адресное пространство.
- процессы взаимодействуют только через предусмотренные системой механизмы межпроцессного взаимодействия.
- переключение контекста между потоками в одном процессе обычно происходит быстрее, чем переключение контекста между процессами


# Примеры:

FastApi

def vs async def

Когда вы объявляете функцию обработки пути обычным образом с ключевым словом def вместо async def, FastAPI ожидает её выполнения, запустив функцию во внешнем пуле потоков, а не напрямую (это бы заблокировало сервер).

https://amirkarimi.dev/blog/2023/07/23/make-fastapi-cpu-bound-endpoints-2x-faster/

ab - Apache HTTP server benchmarking tool

-n requests
Количество запросов, которые необходимо выполнить для сеанса сравнительного анализа.

-c concurrency
Количество нескольких запросов, выполняемых одновременно.

ab -n 1000 -c 100

1тыс запросов, 100 потоков

# Global Interpreter Lock (GIL)

Глобальная блокировка интерпретатора (GIL) в Python гарантирует, что только один поток использует байт-код Python одновременно.

Global Interpreter Lock (GIL) - это механизм, используемый интерпретатором Python, который позволяет только одному потоку выполняться в любой момент времени. Это означает, что в контексте одного процесса Python, даже на многоядерном процессоре, только один поток будет выполняться в любой момент времени.

GIL — это мьютекс, который предотвращает одновременное выполнение нескольких потоков Python-кода. Потоки должны соревноваться за GIL, чтобы получить доступ к выполнению Python-кода. Благодаря этому, GIL гарантирует, что только один поток обрабатывает Python-код в любой момент времени.

GIL был введен чтобы обеспечить безопасность потоков при работе с памятью.

GIL удерживается только одним потоком, выполняющим код Python, в любой момент времени. Когда поток выполняет блокирующую операцию (ввод-вывод или ожидание события, например ответа сервера), GIL освобождается, и другой поток может захватить его и начать выполнение Python-кода. Когда первый поток снова готов к выполнению кода, ему необходимо снова захватить GIL, чтобы продолжить работу.

## Примеры

https://realpython.com/python-parallel-processing/

### java

```java
public class Fibonacci {
    public static void main(String[] args) {
        int cpus = Runtime.getRuntime().availableProcessors();
        for (int i = 0; i < cpus; i++) {
            new Thread(() -> fib(45)).start();
        }
    }
    private static int fib(int n) {
        return n < 2 ? n : fib(n - 2) + fib(n - 1);
    }
}

// real    0m9.758s
// user    0m38.465s
```
user - общее количество секунд процессора, затраченных во всех потоках

Общее время ЦП было почти в четыре раза больше реального времени в этом примере, что означает, что ваши потоки работали параллельно.

![alt](https://files.realpython.com/media/threads_java.7f8a99069dd9.png)

### python

```py
import os
import threading

def fib(n):
    return n if n < 2 else fib(n - 2) + fib(n - 1)

for _ in range(os.cpu_count()):
    threading.Thread(target=fib, args=(35,)).start()

# real    0m8.754s
# user    0m8.778s

```

Затраченное время по существу совпадает с общим временем процессора. Несмотря на создание и запуск нескольких потоков, программа ведет себя так, как если бы она была однопоточной.

![alt](https://files.realpython.com/media/threads_python.6a3d7bf733a5.png)

Все четыре ядра процессора выполняют вычисления, но работают лишь примерно на четверть своего потенциала.

Симметрия указывает на непрерывную миграцию задач между процессорами, что приводит к ненужному переключению контекста и конкуренции за ресурсы.

Когда несколько потоков борются друг с другом за ресурсы вместо того, чтобы работать вместе для достижения общей цели, это серьезно снижает их общую производительность.

GIL позволяет одновременно выполнять только один поток, эффективно превращая многопоточную программу в однопоточную. При этом планировщик задач операционной системы пытается угадать, какой из потоков должен иметь наивысший приоритет, перемещая его с одного ядра на другое.

Всякий раз, когда поток Python выполняет блокирующую операцию ввода-вывода, возврат которой может занять некоторое время, он освобождает GIL и сообщает другим потокам, что теперь они могут попытаться получить блокировку для возобновления выполнения.


# Asyncio

asyncio — это библиотека для написания concurrent кода с использованием синтаксиса async/await.

Awaitable объекты в asyncio - это объекты, которые можно использовать в выражении await.

Awaitable: Сoroutine, Tasks, Futures

await - это ключевое слово, которое используется для переключения между awaitable объектами. Это позволяет вашей программе продолжать выполняться, в то время как другая асинхронная функция выполняется в фоновом режиме. Когда асинхронная функция завершится, await вернет результат.

Сопрограммы (Сoroutine) — это специальные функции, определённые с использованием ключевого слова async def, которые выполняются асинхронно и при вызове возвращают объект сопрограммы, передаваемый в оператор await.

Tasks - это объекты, которые можно ожидать (awaitable), они оборачивают сопрограмму в задачу task для дальнейшего планирования и запуска в event loop. Создается через create_task

```py
task = asyncio.create_task(async_func_name())
```

Когда корутина оборачивается в задачу с помощью функций, create_task, она автоматически запускается в самое ближайшее время.

## Состояние task: Pending, Completed, Cancelled

task.done - возвращает True, если задача выполнена или отменена.

task.result - возвращает результат выполнения задачи, если она выполнена.

task.exception - возвращает исключение, которое было выброшено при выполнении задачи.

task.cancel - отменяет выполнение задачи.

task.cancelling - возвращает True, если задача находится в процессе отмены.


## методы

asyncio.wait_for - ожидает завершения coro, и если выполнение не завершено в течение секунд, вызывается asyncio.TimeoutError.

asyncio.gather - запускает корутины (или Futures) одновременно и собирает результаты их работы

аналог в js - Promise.all()

asyncio.wait - функция которая позволяет ожидать завершения нескольких корутин/future и возвращает два списка: список выполненных корутин и список невыполненных корутин.

return_when=asyncio.FIRST_COMPLETED - вернуть результат по первому выполненному таску

аналог в js - Promise.any()

return_when=asyncio.ALL_COMPLETED - вернуть результат только когда все таски будут выполнены (по умолчанию)

аналог в js - Promise.allSettled()

return_when=asyncio.FIRST_EXCEPTION - вернуть результат по первой возникшей ошибке.



# EventLoop

Event loop - это цикл событий, который последовательно выполняет задачи в одном потоке, а не в нескольких. Он следит за появлением различных событий и привязывает их к соответствующим обработчикам, предварительно определенным в коде.

Позволяет параллельно обрабатывать множество асинхронных задач, ставя на паузу те из них, которые требуют ожидания, и переключаясь между задачами для эффективного использования ресурсов и времени.

Цикл событий сохраняет только слабые ссылки на задачи. Задача, на которую больше нигде нет ссылок, может быть удалена сборщиком мусора в любое время, даже до того, как она будет выполнена.

```py
asyncio.create_task(some_task())

# link
task = asyncio.create_task(some_task())
```


# Проблемы многопоточности

## Атомарность операций

Атомарность операций предполагает, что действие происходит целиком или не происходит совсем, без возможности частичного выполнения или совмещения с другими операциями.

В языке Python многие операции по умолчанию не являются атомарными. Например, обычные операции с переменчивыми структурами данных, такими как списки, словари и множества, не являются атомарными и могут вызвать состояние гонки или ошибку, если несколько потоков одновременно работают с этими данными.

Для достижения атомарности в Python можно использовать механизмы синхронизации: Lock, Condition, Semaphore


## Deadlock

Deadlock(тупик) – это режим сбоя параллельности, когда поток или потоки ждут условия, которое никогда не происходит.

Корутина A: Ожидает корутину B

Корутина B: Ожидает корутину A

## Race Condition

Race Condition (гонка потоков) - это состояние, когда два или более потока (или процесса) пытаются получить доступ к одному и тому же ресурсу одновременно.

# Примитивы синхронизации

## Мьютекс

Это механизм синхронизации, который используется для предотвращения одновременного доступа к общему ресурсу. Cокращение от "взаимное исключение"

Мьютекс может быть в двух состояниях: заблокированном и разблокированном. Когда поток пытается получить доступ к общему ресурсу, он должен сначала «захватить» мьютекс. Если мьютекс свободен, поток получает доступ к ресурсу, и мьютекс переходит в состояние «заблокирован». Если другой поток пытается получить доступ к ресурсу, когда мьютекс заблокирован, этот поток блокируется и ожидает снятия блокировки.

## Lock

Lock - это примитив синхронизации, который используется для ограничения доступа к общему ресурсу. Он реализует концепцию блокировки, которая гарантирует, что в любой момент времени только один поток или корутина может использовать защищаемый ресурс.

lock.acquire - запрашивает блокировку и блокирует корутину если она уже не заблокирована.

lock.release - освобождает блокировку, чтобы другой поток или корутина могли запросить ее

## Event

Событие asyncio может быть используемым для уведомления нескольких asyncio задач о том, что произошло какое-либо событие.


## Condition

Комбинирует функциональность Lock и Event.

Может использоваться задачей для ожидания какого-либо события и затем получения эксклюзивного доступа к общему ресурсу.

## Semaphore

Семафор управляет внутренним счетчиком, который уменьшается при каждом acquire() вызове и увеличивается при каждом release() вызове. Счетчик никогда не может быть ниже нуля; когда acquire() обнаруживает, что оно равно нулю, он блокируется, ожидая, пока какая-то задача не вызовет release().

Может увеличивать значение своего внутреннего счетчика выше начального значения

## BoundedSemaphore

Он ограничивает внутренний счетчик, чтобы не превышал заданное значение.

не может увеличивать значение своего внутреннего счетчика выше начального значения


## Barrier

Барьер в asyncio — это инструмент синхронизации, позволяющий программе ждать, пока все корутины» достигнут определённой точки. Когда все задачи достигают этой точки, они могут продолжить выполнение. Однако основная функция барьера заключается в том, что каждая задача, достигшая барьера, останавливается и ожидает, пока все остальные задачи не достигнут барьера. После того как все задачи достигают барьера, они продолжают выполнение.

# Очереди

**FIFO**, **LIFO**, **Priority**

Очереди позволяет корутинам производителя и потребителя обмениваться данными друг с другом, внутри event loop

Паттерн producer-consumer

Задача A производит данные и помещает их в очередь, а задача B извлекает данные из очереди для обработки.

Это и есть модель "производитель-потребитель", где задача A - производитель, а задача B - потребитель. По аналогии с супермаркетом, покупатели являются производителями, кассиры - потребителями, а очередь покупателей представляет собой очередь.

Задачи-потребители могут одновременно выступать в роли производителей, если генерируют дополнительные элементы, помещаемые в очередь.

# Cron

Cron – это планировщик задач, утилита, позволяющая выполнять скрипты на сервере в назначенное время с заранее определенной периодичностью.

crontab – это таблица с расписанием запуска скриптов и программ, оформленная в специальном формате, который умеет считывать компьютер. Для каждого пользователя системы создается отдельный crontab-файл со своим расписанием. Эта встроенная в Linux утилита доступна на низком уровне в каждом дистрибутиве.

https://crontab.guru

```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

> "Часть >/dev/null означает «перенаправить данные из stdout в /dev/null», а часть 2>&1 означает «перенаправить данные из stderr в stdout». Таким образом мы перенаправили весь вывод команды в пустоту."

# Очереди задач

Пользовательский интерфейс (UI) — это то, как человек взаимодействует с программой, а программный интерфейс (API) — это то, как программа взаимодействует с другой программой. Система очередей предлагает программный интерфейс, который программы используют для взаимодействия асинхронно, а не в реальном времени.

![alt](https://dev-to-uploads.s3.amazonaws.com/uploads/articles/rwosfraplff3jbd7wa08.png)

## Брокер сообщений

Брокер сообщений (англ. message broker, integration broker, interface engine) — архитектурный шаблон в распределённых системах; приложение, которое преобразует сообщение по одному протоколу от приложения-источника в сообщение протокола приложения-приёмника, тем самым выступая между ними посредником.

Брокер сообщений представляет собой тип построения архитектуры, при котором элементы системы «общаются» друг с другом с помощью посредника. Благодаря его работе происходит снятие нагрузки с веб-сервисов, так как им не приходится заниматься пересылкой сообщений: всю сопутствующую этому процессу работу он берёт на себя.

В работе любого брокера сообщений используются две основные сущности:

- Producer / Publisher — занимается отправкой сообщения в брокер;
- Consumer / Subscriber — получает и обрабатывает сообщения из брокера;

![alt](https://academy.mediasoft.team/upload/images/articles/%D0%A1%D0%BD%D0%B8%D0%BC%D0%BE%D0%BA%20%D1%8D%D0%BA%D1%80%D0%B0%D0%BD%D0%B0%202023-08-01%20%D0%B2%2018.07%201.png)

**Примеры брокеров сообщений**

- Apache Kafka
- RabbitMQ
- Redis
- Amazon SQS

**Примеры где используются**

Обмен данными: могут быть использованы для обмена данными между приложениями, сервисами или микросервисами.

Отложенное выполнение действий. Когда нужно выполнить тяжелые операции, но не обязательно их выполнять в момент запроса от пользователя.


## Celery

Celery – это асинхронная распределенная очередь задач, написанная на Python, она предназначена для обработки сообщений в реальном времени при помощи многозадачности. Используя Celery, можно организовать выполнение задач в фоновом режиме, не загружая основной поток приложения.

Celery требуется брокер сообщений для связи.

https://habr.com/ru/articles/733452/

https://proglib.io/p/django-celery-i-redis-gayd-po-rabote-s-asinhronnymi-zadachami-2022-08-22


# misc

```
https://habr.com/ru/companies/wunderfund/articles/586360/
https://fastapi.tiangolo.com/ru/async/#_16
https://codechick.io/tutorials/python/python-threading
https://sky.pro/wiki/python/parallelizatsiya-tsiklov-v-python-mnogopotochnost-i-protsessy/
https://dvmn.org/encyclopedia/web-server/deploy-wsgi-gunicorn-django-flask/
https://ru.stackoverflow.com/questions/1263427/%D0%90%D1%81%D0%B8%D0%BD%D1%85%D1%80%D0%BE%D0%BD%D0%BD%D0%BE%D1%81%D1%82%D1%8C-%D0%B2-fastapi-python
https://stackoverflow.com/questions/63454072/multiprocessing-multithreading-gil

https://realpython.com/python-parallel-processing/
https://realpython.com/python-concurrency/

https://superfastpython.com/multiprocessing-vs-gil-in-python/
https://ysk24ok.github.io/2021/09/02/difference_between_def_and_async_def_in_fastapi.html

https://testdriven.io/blog/python-concurrency-parallelism/
https://testdriven.io/blog/concurrency-parallelism-asyncio/
https://github.com/testdrivenio/parallel-concurrent-examples-python
https://amirkarimi.dev/blog/2023/07/23/make-fastapi-cpu-bound-endpoints-2x-faster/

https://github.com/tiangolo/fastapi/issues/3725
```