import asyncio
import time
from fastapi import FastAPI

app = FastAPI()

banking_account = 300

async def withdraw(amount):
    global banking_account
    msg = ""
    if banking_account >= amount:
        msg = "Достаточно денег для снятия"
        await asyncio.sleep(1)
        banking_account -= amount
    else:
        msg = "Денег не достаточно"

    return [banking_account, msg]

@app.get("/balance")
async def balance():
    await asyncio.sleep(3)
    result, msg = await withdraw(250)

    return {"balance": result, "message": msg}





# lock = asyncio.Lock()

# async def withdraw(amount):
#     global banking_account

#     async with lock:
#         msg = ""
#         if banking_account >= amount:
#             msg = "Достаточно денег для снятия"
#             await asyncio.sleep(1)
#             banking_account -= amount
#         else:
#             msg = "Денег не достаточно"

#         return [banking_account, msg]

# @app.get("/balance")
# async def balance():
#     await asyncio.sleep(3)
#     result, msg = await withdraw(250)

#     return {"balance": result, "message": msg}
