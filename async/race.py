import asyncio

banking_account = 300

async def withdraw(amount):
    global banking_account

    if banking_account >= amount:
        print(f"Достаточно денег для снятия")
        await asyncio.sleep(1)
        banking_account -= amount
    else:
        print(f"Денег не достаточно")

async def main():
    task1 = asyncio.create_task(withdraw(200))
    task2 = asyncio.create_task(withdraw(250))

    await task1
    await task2
    # await asyncio.gather(task1, task2)

    print(f'Остаток {banking_account}')

asyncio.run(main())



# async def withdraw(amount, lock):
#     global banking_account

#     async with lock:
#         if banking_account >= amount:
#             print(f"Достаточно денег для снятия")
#             await asyncio.sleep(1)
#             banking_account -= amount
#         else:
#             print(f"Денег не достаточно")

# async def main():

#     lock = asyncio.Lock()

#     task1 = asyncio.create_task(withdraw(200, lock))
#     task2 = asyncio.create_task(withdraw(250, lock))

#     await task1
#     await task2
#     # await asyncio.gather(task1, task2)

#     print(f'Остаток {banking_account}')

# asyncio.run(main())


# async def withdraw(amount, lock):
#     global banking_account

#     await lock.acquire()

#     try:
#         if banking_account >= amount:
#             print(f"Достаточно денег для снятия")
#             await asyncio.sleep(1)
#             banking_account -= amount
#         else:
#             print(f"Денег не достаточно")
#     finally:
#         lock.release()


# async def main():

#     lock = asyncio.Lock()

#     task1 = asyncio.create_task(withdraw(200, lock))
#     task2 = asyncio.create_task(withdraw(250, lock))

#     await task1
#     await task2
#     # await asyncio.gather(task1, task2)

#     print(f'Остаток {banking_account}')

# asyncio.run(main())
