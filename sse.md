# Polling

Метод, при котором клиент периодически отправляет запросы на сервер для проверки наличия новых данных.

# Long Polling

Клиент отправляет запрос на сервер, и сервер держит этот запрос открытым до тех пор, пока не появятся новые данные. Как только данные появляются, сервер отправляет их клиенту, и клиент сразу же отправляет новый запрос.

# WebSocket

Протокол, который обеспечивает двустороннюю связь между клиентом и сервером через одно соединение. Это позволяет серверу отправлять данные клиенту в реальном времени без необходимости в запросах от клиента.

# Server-Sent Events (SSE)

Технология, которая позволяет серверу отправлять обновления клиенту через однонаправленное соединение. Клиент открывает соединение и получает обновления от сервера в реальном времени.

# Протокол Mercure (SSE)

https://mercure.rocks/spec

![alt](https://mercure.rocks/static/main.png)

Протокол, основанный на SSE, который позволяет отправлять обновления в реальном времени клиентам.