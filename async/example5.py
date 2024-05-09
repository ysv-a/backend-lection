import asyncio

async def operation1():
    print("Запущена operation1")
    await asyncio.sleep(6)
    print("Завершение operation1")

async def operation2():
    print("Запущена operation2")
    await asyncio.sleep(2)
    print("Завершение operation2")

async def main():
    tasks = [asyncio.create_task(operation1()), asyncio.create_task(operation2())]
    done, pending = await asyncio.wait(tasks, return_when=asyncio.ALL_COMPLETED)

    for task in done:
        print("Задание завершено: ", task)

    for task in pending:
        print("Задание ожидает выполнения: ", task)
        # result = await task
        task.cancel()

        try:
            await task
        except asyncio.CancelledError:
            print("Задача отменена")

asyncio.run(main())
