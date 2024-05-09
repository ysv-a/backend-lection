import asyncio
import time

start_time = time.time()

async def work1(x):
    await asyncio.sleep(x)
    return x * 3

async def work2(x):
    await asyncio.sleep(x)
    return x + 1

async def main():
    result_1 = await work1(1)
    result_2 = await work2(result_1)

    # task1 = asyncio.create_task(work1(2))
    # result_1 = await task1
    # task2 = asyncio.create_task(work2(result_1))
    # result_2 = await task2

    print(f"Result future_1: {result_1}")
    print(f"Result future_2: {result_2}")

    end_time = time.time()
    print('Время окончания: ' + str((end_time - start_time)))

asyncio.run(main())
