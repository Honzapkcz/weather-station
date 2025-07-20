import RPi.GPIO as pins
from time import time

pins.setmode(pins.BOARD)
pins.setup(11, pins.IN)

lastping = time()
state = pins.input(11)

try:
    while True:
            if pins.input(11):
                state = 1
            elif not pins.input(11) and state:
                print("ping: %s s\t %s Hz" % (time() - lastping, 1 / (time() - lastping)))
                state = 0
                lastping = time()
except:
    pins.cleanup()
