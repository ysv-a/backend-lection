import time
import asyncio

start_time = time.time()

async def fetch(url):
    print(f'start_fetch {url}')
    await asyncio.sleep(3)
    return f"Data from {url}"

async def main():
    data1 = await fetch("https://www.google.com")
    data2 = await fetch("https://www.ya.com")
    print(data1)
    print(data2)

    #result = await asyncio.gather(fetch("https://www.example1.com"), fetch("https://www.example2.com"))

    end_time = time.time()
    print('Время окончания: ' + str((end_time - start_time)))

asyncio.run(main())
