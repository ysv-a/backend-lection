import asyncio

async def fetch():
    print('Start Fetch')
    await asyncio.sleep(2)
    return "Результат"

def handler(task):
    result = task.result()
    print(f"Результат Callback функции: {result}")

async def main():
    task = asyncio.create_task(fetch())
    task.add_done_callback(handler)
    await task

asyncio.run(main())
