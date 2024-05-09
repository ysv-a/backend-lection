import asyncio
import time
from fastapi import FastAPI

app = FastAPI()


@app.get("/one")
async def read_root():
    # start = time.perf_counter()
    #await asyncio.sleep(10)
    time.sleep(100)
    # finish = time.perf_counter()
    # t = str(finish - start)
    return {"first_root": "HELLO"}

@app.get("/two")
async def read_item():
    await asyncio.sleep(6)
    return {"second_root": "two"}
