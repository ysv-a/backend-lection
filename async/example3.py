import time
import asyncio

start_time = time.time()

async def fetch(url):
    print(f'start_fetch {url}')
    await asyncio.sleep(3)
    return f"Data from {url}"

async def main():
    task1 = asyncio.create_task(fetch("https://www.google.com"))
    task2 = asyncio.create_task(fetch("https://www.ya.com"))

    data1 = await task1
    data2 = await task2

    print(data1)
    print(data2)


    # tasks = [asyncio.create_task(fetch(i)) for i in range(5)]
    # await asyncio.gather(*tasks)

    end_time = time.time()
    print('Время окончания: ' + str((end_time - start_time)))

asyncio.run(main())
