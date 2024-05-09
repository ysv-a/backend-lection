from random import randint
import asyncio

# покупатели
async def producer(queue):
    print('Производитель: Запущен')
    for _ in range(5):
        value = randint(1, 5)
        print('Добавлаяем в очередь данные')
        await asyncio.sleep(value)
        await queue.put(value)

    await queue.put(None)

    print('Производитель: конец очереди')

# кассиры
async def consumer(queue):
    print('Потребитель: Запущен')
    while True:
        item = await queue.get()
        if item is None:
            break
        print(f'>Потребитель получил сумму денег: {item}')

    print('Потребитель: очередь обработана')

async def main():
    # очередь покупателей
    queue = asyncio.Queue()
    await asyncio.gather(producer(queue), consumer(queue))

asyncio.run(main())
