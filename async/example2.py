import time
import asyncio

start_time = time.time()

async def fetch(url):
    print(f'start_fetch {url}')
    await asyncio.sleep(3)
    return f"Data from {url}"

async def main():
    result = await asyncio.gather(fetch("https://www.google.com"), fetch("https://www.ya.com"))
    #task_lists = [fetch("https://www.google.com"), fetch("https://www.ya.com")]
    #result = await asyncio.gather(*task_lists)
    print(result)

    end_time = time.time()
    print('Время окончания: ' + str((end_time - start_time)))

asyncio.run(main())
