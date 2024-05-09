import asyncio

async def waiter(event):
    print('waiting for it ...')
    await event.wait()
    print('... got it!')

async def main():
    # Создайте объект Event.
    event = asyncio.Event()

    # Создать задачу, чтобы подождать, пока не будет установлено "событие2.
    waiter_task = asyncio.create_task(waiter(event))

    # Спать в течение 1 секунды и установить событие.
    await asyncio.sleep(1)
    event.set()

    await waiter_task

asyncio.run(main())
