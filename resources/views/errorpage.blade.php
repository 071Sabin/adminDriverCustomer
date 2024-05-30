admin id: admin@gmail.com
admin pwd: sabin123

remaining:
> driver profile picture upload and show in admin section, show customer profile picture in admin section

> admin can't reject the driver kyc.

> if possible, count kyc rejections

> disable the delete button for both customer and driver if the kyc is once verified.

> profile pictures for admin

> searching for particular customer/driver with id/email in approved customer and wallets for both customer and driver.
> customer uploading their kyc verification and limiting wallet access/order until it is verified.

> the reject button in admin panel has to be managed in proper way, its returning dd() fn//else remove reject button,
they are not approved means they are rejected.

> customer orders, selects drivers according to the ares of their address else customer can't order as there are no 
drivers for their area. else there will be problem as drivers need to drive a long trip.


> now if the customer is approved but we deleted their wallet. then there comes a problem, so when customer logins, if
the wallet is not there take from the transactions table, grab the latest transactions new balance with their walletid
and
cust id then only the problem will be solved. To do
this, we need to do the initial transactions on this walletid thought the balance is zero. so if user wallet is deleted
at the amount zero then we can retrive easily.

> need to do some needed try catch for issues.
> password reset with real emails.

>>>>> workdone till now:
admin: can see customer details, wallets, topup, rates per mile and all.
admin: driver wallets, topup, see the driver kyc file and profile pictures, setup for that.
admin: can see all the wallets transactions of particular customer/driver in wallets section in website.
admin: dashboard can broadcast and delete the broadcast messages for customer and drivers either primary or urgent
basis.


customer: dashboard shows current balance, profile they can update their name, phone, profile picture for now.
they can upload their kyc.

same as customer for drivers.
