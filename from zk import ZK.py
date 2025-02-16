from zk import ZK

zk = ZK('192.168.1.200', port=4370)  # Replace with your device IP
conn = zk.connect()

if conn:
    print("Connected to K40!")
    conn.set_user(uid=2, id='1002', name='John Doe', privilege=0, password='1234')
    conn.disconnect()
else:
    print("Failed to connect")
