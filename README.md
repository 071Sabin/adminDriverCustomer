<strong> Laravel Project: Admin, Customer, and Driver Management System</strong>

Project Overview

This Laravel project is designed to manage the interactions between three types of users: Admin, Customer, and Driver. The system includes user registration and verification processes, order tracking, KYC (Know Your Customer) verification, and wallet management. The admin has comprehensive control over user accounts and can broadcast messages, adjust wallet balances, and set pricing parameters.

 **Features**

 User Management

- Customer and Driver Signup: 
  - Both customers and drivers can sign up for the service.
  - Signup requests require approval from an admin.

- KYC and Profile Picture Verification:
  - Customers and drivers must upload their KYC documents and profile pictures.
  - Admins review and approve these documents.

- Account Approval:
  - Admins approve or reject signup requests.
  - Wallets are created upon approval of the signup.
  - Admins can dismiss accounts or reject signups if policies are violated, forfeiting any existing wallet balance.

 Order Management

- Order Placement and Tracking:
  - Customers can place orders only after KYC verification.
  - Drivers can view and accept orders only after KYC verification.
  - Order tracking is integrated with third-party services and updates are sent via email.

 **Admin Capabilities**

- Broadcast Messaging:
  - Admins can send broadcast messages to all customers and drivers.

- Wallet Management:
  - Admins can edit wallet balances for both customers and drivers.
  
- Profile Management:
  - Admins can view and edit personal details, KYC documents, and profile pictures for both customers and drivers.

- Pricing Controls:
  - Admins can set and adjust the rate per mile, commission rates, and minimum charges.
