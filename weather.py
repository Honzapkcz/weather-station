import adafruit_dht
import board
import sqlite3
from time import sleep, time
import RPi.GPIO as pins

pins.setup(17, pins.IN)

lastping = time()
lasttemp = time() - 50
state = pins.input(17)
pings = []

dht = adafruit_dht.DHT11(board.D4, use_pulseio=False)
sql = sqlite3.connect("www/data.db")
c = sql.cursor()

# try:
while True:
    # wind speed
    if pins.input(17):
        state = 1
    elif not pins.input(17) and state:
        vel = 2 * 3.14 * 0.13 * (1 / (time() - lastping))
        print("ping: %s Hz\t %s m/s" % (round(1 / (time() - lastping), 2), round(vel, 2)))
        if vel < 30:
            pings.append(vel)
        state = 0
        lastping = time()
    # temp & humi measure; insert to db
    if time() - lasttemp > 60: 
        try:
            lasttemp = time()
            temp = dht.temperature
            humi = dht.humidity
            wind = round(sum(pings) / len(pings), 2) if len(pings) else 0
            print("insert: %s °C\t %s %%\t %s mm\t %s m/s" % (temp, humi, 0, wind))
            c.execute("INSERT INTO data (temperature, humidity, water, wind) VALUES (?, ?, ?, ?)", (temp, humi, 0, wind))
            sql.commit()
            pings = []
        except Exception as e:
            print("error: ", e)
# except Exception as e:
#     print("error: ", e)
#     print("[terminating]")
#     pins.cleanup()
#     pins.cleanup()
#     sql.commit()
#     sql.close()



