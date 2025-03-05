# ข้อมูลบัญชี
account = {"ณัฐณิชา": 500, "ชลนิกานต์": 500}

# เมนูหลัก
def mainmenu():
    print("\n[เมนูหลัก]")
    print("1. เปิดบัญชี")
    print("2. ฝากเงิน")
    print("3. ถอนเงิน")
    print("4. โอนเงิน")
    print("5. เช็กยอด")
    print("6. ปิดบัญชี")
    print("7. ออกจากโปรแกรม")

# ถามว่าต้องการทำรายการต่อหรือไม่
def answer():
    ans = input("ต้องการที่จะทำรายการต่อหรือไม่ (Y/N) : ")
    if ans.lower() == "n":
        print("ขอบคุณที่ใช้บริการ")
        exit()
    elif ans.lower() == "y":
        run()
    else:
        print("ไม่มีในระบบ กรุณาพิมพ์ใหม่อีกครั้ง")
        answer()

# เปิดบัญชี
def newaccount():
    try:
        print("\n[เปิดบัญชี]")
        add_name = input("กรุณาระบุชื่อจริง : ")
        if add_name not in account:
            addmoney = int(input("เงินเปิดบัญชี : "))
            if addmoney <= 0:
                raise Exception("ค่าของตัวเลขต้องเป็นบวกเท่านั้น")
            account[add_name] = addmoney
            print("ลงทะเบียนเสร็จสิ้น")
        else:
            print("ชื่อนี้ได้ทำการลงทะเบียนไปแล้ว")
    except Exception as e:
        print(e)
    answer()

# ฝากเงิน
def deposit():
    try:
        print("\n[ฝากเงิน]")
        name = input("กรุณาระบุชื่อบัญชี : ")
        if name in account:
            money = int(input(f"ฝากเงินเข้าบัญชีคุณ {name} : "))
            if money <= 0:
                raise Exception("ค่าของตัวเลขต้องเป็นบวกเท่านั้น")
            account[name] += money
            print(f"ยอดเงินคงเหลือในบัญชีของคุณ {name} : {account[name]}")
        else:
            print("กรุณาเปิดบัญชีก่อน")
    except Exception as e:
        print(e)
    answer()

# ถอนเงิน
def withdraw():
    try:
        print("\n[ถอนเงิน]")
        name = input("กรุณาระบุชื่อบัญชี : ")
        if name in account:
            money = int(input(f"ถอนเงินออกจากบัญชีคุณ {name} : "))
            if money <= 0:
                raise Exception("ค่าของตัวเลขต้องเป็นบวกเท่านั้น")
            if money > account[name]:
                raise Exception("ยอดเงินในบัญชีไม่พอ")
            account[name] -= money
            print(f"ยอดเงินคงเหลือในบัญชีของคุณ {name} : {account[name]}")
        else:
            print("กรุณาเปิดบัญชีก่อน")
    except Exception as e:
        print(e)
    answer()

# ปิดบัญชี
def deleteaccount():
    print("\n[ปิดบัญชี]")
    delete = input("กรุณาระบุชื่อบัญชีที่ต้องการปิด : ")
    if delete in account:
        del account[delete]
        print("ปิดบัญชีเสร็จสิ้น")
    else:
        print("ไม่มีชื่อนี้อยู่ในระบบ")
    answer()

# โอนเงิน
def transfer():
    try:
        print("\n[โอนเงิน]")
        sender = input("กรุณาระบุชื่อผู้โอน : ")
        if sender not in account:
            print("ไม่มีชื่อผู้ใช้อยู่ในระบบ \nกรุณาเปิดบัญชีก่อน")
            answer()
        receiver = input("กรุณาระบุชื่อผู้รับ : ")
        if receiver not in account:
            print("ไม่มีชื่อผู้ใช้อยู่ในระบบ \nกรุณาเปิดบัญชีก่อน")
            answer()
        amount = int(input(f"กรุณาระบุจำนวนเงินที่คุณ {sender} ต้องการโอน : "))
        if amount <= 0:
            raise Exception("ค่าของตัวเลขต้องเป็นบวกเท่านั้น")
        if account[sender] >= amount:
            account[sender] -= amount
            account[receiver] += amount
            print("การโอนเงินเสร็จสิ้น")
            print(f"ยอดเงินคงเหลือในบัญชีของคุณ {sender} : {account[sender]}")
        else:
            print("ยอดเงินในบัญชีของคุณไม่เพียงพอ")
    except Exception as e:
        print(e)
    answer()

# เช็กยอดเงินคงเหลือ
def check():
    print("\n[เช็กยอด]")
    name = input("กรุณาระบุชื่อบัญชี : ")
    if name in account:
        print(f"ยอดเงินคงเหลือในบัญชีของคุณ {name} : {account[name]}")
    else:
        print("ไม่มีชื่อนี้ในระบบ")
    answer()

# ฟังก์ชันหลัก
def run():
    while True:
        mainmenu()
        try:
            work = int(input("เลือกหัวข้อเพื่อทำงาน : "))
            if work == 1:
                newaccount()
            elif work == 2:
                deposit()
            elif work == 3:
                withdraw()
            elif work == 4:
                transfer()
            elif work == 5:
                check()
            elif work == 6:
                deleteaccount()
            elif work == 7:
                print("ขอบคุณที่ใช้บริการ")
                break
            else:
                print("ไม่มีในระบบ กรุณาพิมพ์หมายเลขที่มีในระบบ")
        except ValueError:
            print("กรุณาป้อนตัวเลขเท่านั้น")

# เริ่มโปรแกรม
run()
