import asyncio

async def mega_task():
    await asyncio.sleep(5)
    return 'Привет мир!'

async def main():
    await asyncio.wait_for(mega_task(), timeout=3)
    # task = asyncio.create_task(mega_task())

    # try:
    #     await asyncio.wait_for(task, timeout=3)
    # except asyncio.TimeoutError:
    #     print("Задача не была завершена в установленное время")

asyncio.run(main())
