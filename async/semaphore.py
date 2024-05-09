import asyncio

# semaphore = asyncio.Semaphore(2)

# async def function_action(id):
#     print(f'Корутина {id} начинает работу')
#     async with semaphore:
#         print(f'Корутина {id} в семафоре')
#         await asyncio.sleep(1)
#         print(f'Корутина {id} вышла из семафора')

# async def main():
#     await asyncio.gather(function_action('один'), function_action('два'), function_action('три'))

# asyncio.run(main())


# semaphore = asyncio.BoundedSemaphore(2)

# async def function_action(id):
#     print(f'Корутина {id} начинает работу')
#     async with semaphore:
#         print(f'Корутина {id} в семафоре')
#         await asyncio.sleep(1)
#         print(f'Корутина {id} вышла из семафора')

# async def main():
#     await asyncio.gather(function_action('один'), function_action('два'), function_action('три'))

# asyncio.run(main())


# semaphore = asyncio.Semaphore(1)

# async def function_action(id):
#     print(f'Корутина {id} начинает работу')
#     await semaphore.acquire()

#     print(f'Корутина {id} в семафоре')
#     await asyncio.sleep(1)
#     print(f'Корутина {id} вышла из семафора')

#     semaphore.release()
#     semaphore.release()


# async def main():
#     await asyncio.gather(function_action('один'), function_action('два'), function_action('три'), function_action('четыре'))

# asyncio.run(main())
