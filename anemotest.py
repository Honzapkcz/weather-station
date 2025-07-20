import RPi.GPIO as pins

pins.setmode(pins.BOARD)
pins.setup(11, pins.IN)

try:
    while True:
        print(pins.input(11))
except:
    pins.cleanup()
