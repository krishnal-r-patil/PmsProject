# logic behind the calculations are
class BankAccount:
    def __init__(self, name, balance):
        self.name = name
        self.balance = balance

    def deposit(self, amount):
        self.balance += amount
        print(f"₹{amount} deposited successfully.")

    def withdraw(self, amount):
        if amount > self.balance:
            print("Insufficient balance!")
        else:
            self.balance -= amount
            print(f"₹{amount} withdrawn successfully.")

    def send_money(self, receiver, amount):
        if amount > self.balance:
            print("Not enough balance!")
        else:
            self.balance -= amount
            receiver.balance += amount
            print(f"₹{amount} sent to {receiver.name}")

    def show_balance(self):
        print(f"{self.name}'s Balance: ₹{self.balance}")


# accounts
accounts = [
    BankAccount("Amit", 1000),
    BankAccount("Rahul", 1500),
    BankAccount("Sneha", 2000)
]


# program
while True:
    print("\n===== Wellcome User, Select Account =====")
    for i in range(len(accounts)):
        print(f"{i+1}. {accounts[i].name}")

    print("0. Exit")

    choice = int(input("Select user: "))

    if choice == 0:
        print("Thankyou for your visit, Exiting system...")
        break

    if choice < 1 or choice > len(accounts):
        print("Invalid selection!")
        continue

    current_user = accounts[choice - 1]

    #  main menu
    while True:
        print(f"\n===== {current_user.name}'s Menu =====")
        print("1. Deposit")
        print("2. Withdraw")
        print("3. Send Money")
        print("4. Check Balance")
        print("5. Back to User Selection")

        option = int(input("Enter choice: "))

        if option == 1:
            amount = float(input("Enter amount: "))
            current_user.deposit(amount)

        elif option == 2:
            amount = float(input("Enter amount: "))
            current_user.withdraw(amount)

        elif option == 3:
            print("\nSelect Receiver:")
            for i in range(len(accounts)):
                print(f"{i+1}. {accounts[i].name}")

            r = int(input("Enter receiver: "))
            if r < 1 or r > len(accounts):
                print("Invalid receiver!")
                continue

            receiver = accounts[r - 1]
            amount = float(input("Enter amount: "))
            current_user.send_money(receiver, amount)

        elif option == 4:
            current_user.show_balance()

        elif option == 5:
            break

        else:
            print("Invalid option!")

 def deposit(self, amount):
    if amount <= 0:
        print("Invalid amount!")
        return
    self.balance += amount
    print(f"₹{amount} deposited successfully.")

def withdraw(self, amount):
    if amount <= 0:
        print("Invalid amount!")
        return
    if amount > self.balance:
        print("Insufficient balance!")
    else:
        self.balance -= amount
        print(f"₹{amount} withdrawn successfully.")
