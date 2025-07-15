import adafruit_dht
import board
import sqlite3
from time import sleep

dht = adafruit_dht.DHT11(board.D4)
sql = sqlite3.connect("www/data.db")
c = sql.cursor()

while True:
    try:
           temp = dht.temperature
           humi = dht.humidity
           c.execute("INSERT INTO data (temperature, humidity, water, wind) VALUES (?, ?, ?, ?)", (temp, humi, 0, 0))
           sql.commit()
           print("temp %s humi %s" % (temp, humi))
    except RuntimeError as e:
        print(e)
    except KeyboardInterrupt:
        print("[terminating]")
        sql.commit()
        sql.close()
    sleep(120.0)
