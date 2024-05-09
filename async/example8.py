import asyncio

async def failing():
    await asyncio.sleep(1)
    raise ValueError("Возникла ошибка в функции failing")

async def successful():
    await asyncio.sleep(1)
    print("Успешное выполнение функции")
    return '500000'

async def main():
    tasks = [asyncio.create_task(failing()), asyncio.create_task(successful())]

    try:
        await asyncio.gather(*tasks)
    except ValueError as _ex:
        print(_ex)

    for i, task in enumerate(tasks):
        task_exception = task.exception()
        if task_exception:
            print(f"Задача {i}: Исключение - {task_exception}")
        else:
            print(f"Задача {i}: Успешно выполнена. Результат: {task.result()}")

asyncio.run(main())
